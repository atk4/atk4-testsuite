<?php
class Model_Author extends Model_Testbed_Author{
    public $table='author';
    function init(){
        parent::init();

        //$this->addField('long_name');
        $this->addField('name');
        $this->addField('email');

        $this->hasMany('Book');
        $this->hasOne('Contact','my_contact');  // one to one relation
    }
}

