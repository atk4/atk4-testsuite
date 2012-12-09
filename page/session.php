<?php
class page_session extends Page_Tester {
    function init(){
        $this->c=$this->add('Controller_Data_Session');
        parent::init();
    }
    function prepare(){
        $m=$this->add('Model');

        $m->addField('test');
        $m->table='test_table';

        $m->setSource($this->c);
        return array($m);
    }

    function test_save($m){

        $m['test']=123;
        $m->save(1);

        return $m->id;
    }
    function test_load($m){

        $m->load(1);

        return $m['test'];
    }
}
