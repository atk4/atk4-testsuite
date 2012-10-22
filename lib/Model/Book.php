<?php
class Model_Book extends Model_Table {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');

        $this->hasOne('Author');
    }
}
