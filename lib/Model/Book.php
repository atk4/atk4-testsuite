<?php
class Model_Book extends Model_Testbed_Book {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');

        $this->hasOne('Author');
        $this->hasMany('Chapter');
    }
}
