<?php
class Model_Contact extends Model_Testbed_Contact{
    public $table='author';
    function init(){
        parent::init();

        $this->addField('street');
        $this->addField('line1');

        //$this->hasOne('Author');  // one to one relation
    }
}

