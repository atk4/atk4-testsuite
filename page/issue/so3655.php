<?php
class Model_Grant extends Model_Table {
	public $table='grant';
	function init(){
		parent::init();
		$this->addField('name');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}
class Model_Finances extends Model_Table {
    public $table='finances';

    function init() {
        parent::init();

        $this->hasOne('Grant');

        $this->addField('fiscal_year')->datatype('int');
        $this->addField('requested')->datatype('money');
        $this->addField('committed')->datatype('money');
        $this->addField('spent')->datatype('money');

        $this->getField('grant')->hidden(true);

        $this->addHook('beforeSave',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
    }

    function beforeSave($model){
        $exist = $this->api->db->dsql()
                      ->table($this->table)
                      ->field('count(1)')
                      ->where('grant_id', 2) //manually set ID for testing.
                      ->where('fiscal_year', $model['fiscal_year'])
                      ->do_getOne();
        // Validate fiscal year before saving
        if($exist[0]) {
            throw $this->exception('Fiscal year for this grant already exists','ValidityCheck')
            	->setField('fiscal_year');
        }
    }
}
class page_issue_so3655 extends Page {
	function init(){
		parent::init();

		$this->add('CRUD')->setModel('Grant');
		$finances = $this->add('Model_Finances');
		$finances->getField('fiscal_year')->mandatory(true);
		$crud=$this->add('CRUD');
		$crud->setModel($finances);
		if($crud->grid)$crud->grid->addTotals(array('requested', 'committed', 'spent'));
	}
}
