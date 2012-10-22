<?php
class Model_Author extends Model_Table {
    public $table='author';
    function init(){
        parent::init();

        $this->addField('long_name');
        $this->addField('name');
        $this->addField('email');

        $this->hasMany('Book');
        $this->hasOne('Contact','my_contact');
        $this->add('dynamic_model/Controller_AutoCreator');
    }
}

