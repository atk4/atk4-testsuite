<?php
class page_ui_grid extends Page {
    function init(){
        parent::init();
        //phpinfo();
        $this->api->db=$this->api->add('DB')->connect();
        $grid = $this->add('Grid');
        $model=$grid->setModel('MyModel');
        $grid->getColumn('name')->makeSortable();

        $grid->addPaginator(5);
        $grid->addTotals();
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
class Model_MyModel extends Model_Table {
    public $table='user';
    function init(){
        parent::init();

        $this->addField('name')->defaultValue('John');

        $this->addExpression('age')->set(function(){
            return 123;
        });

        $this->hasOne('Client')->sortable(true)->caption('CLLL');
    }
}
