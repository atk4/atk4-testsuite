<?php
class page_modelmemcached extends Page_Tester {
    public $proper_responses=array(
        "Test_connect"=>'OK',
        "Test_save"=>'20',
        "Test_load"=>'Smith',
        "Test_delete"=>'',
        "Test_load2"=>'Unable to load data',
        "Test_deleteAll"=>'',
        "Test_load3"=>'Unable to load data'
    );
    function prepare(){

        $m=$this->add('Model',array('table'=>'test'));
        $m->addField('name');
        $m->setSource('Memcached','test1');

        return array($m);
    }
    function test_connect($m){
        return 'OK';
    }
    function test_save($m){
        $m['name']='John';
        $m->save(15);

        $m['name']='Smith';
        $m->save(20);
        return $m->id;
    }
    function test_load($m){
        $m->load(20);
        return $m['name'];
    }
    function test_delete($m){
        $m->delete(20);
        return $m['name'];
    }
    function test_load2($m){
        try{
        $m->load(20);
        return $m['name'];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    function test_save2($m){

        $m2=$this->add('Model',array('table'=>'test2'));
        $m2->addField('name');
        $m2->setSource('Memcached','test1');
        $m2['name']='Bill';
        $m2->save(33);
    }
    function test_load2a($m){
        try{
        $m->load(33);
        return $m['name'];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    function test_deleteAll($m){

        $m->deleteAll();
    }
    function test_load3($m){
        try{
        $m->load(15);
        return $m['name'];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    function test_load4($m){
        $m2=$this->add('Model',array('table'=>'test2'));
        $m2->addField('name');
        $m2->setSource('Memcached','test1');
        $m2->load(33);
        return $m2['name'];
    }
}
