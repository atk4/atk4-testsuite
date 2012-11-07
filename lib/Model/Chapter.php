<?php
class Model_Chapter extends Model_Testbed_Chapter {
    public $table='chapter';
    function init(){
        parent::init();

        $this->addField('title');

        $this->hasOne('Book');
        $this->hasMany('Section');

        $this->addField('abstract');
        $this->addField('no');
    }
}
