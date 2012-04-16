<?php
class page_crud extends Page {
    function init(){
        parent::init();
        //phpinfo();
        $this->api->db=$this->api->add('DB')->connect();
        $model = $this->add('CRUD')->setModel('MyModel');
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

        $this->hasOne('Client');
    }
}
