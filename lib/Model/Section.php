<?php
class Model_Section extends Model_Testbed_Section {
    public $table='section';
    function init(){
        parent::init();

        $this->addField('title');

        $this->hasOne('Section');
    }
}
