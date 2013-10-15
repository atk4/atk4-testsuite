<?php
class page_ui_crud extends Page {
    function init(){
        parent::init();
        //phpinfo();
        $this->api->db=$this->api->add('DB')->connect();
        $crud = $this->add('CRUD');
        $model=$crud->setModel('MyModel');
        if($crud->grid){
            $crud->grid->getColumn('name')->makeSortable();
        }
    }

}
class Model_Client extends Model_Table {
    public $entity_code='client';
    function init(){
        parent::init();

        $this->addField('name');

        $this->addField('email');

    }
}
class Model_MyModel extends Model_Table{
    public $table='user';
    function init(){
        parent::init();

        $this->addField('name')->defaultValue('John')->type('text');
        $this->addField('is_timereport')->type('boolean')
            ->enum(array('Y','N'))
            ->caption('Alert is set');

        $this->addExpression('age')->set(function(){
            return 123;
        });

        $x=$this->hasOne('Client');
        $x->sortable(true)->caption('CLL');
    }
}
