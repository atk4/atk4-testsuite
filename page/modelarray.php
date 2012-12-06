<?php

class page_modelarray extends Page_Tester {
    function prepare(){
    }
    function test_populate(){
        $m=$this->add('Model');
        $m->addField('test');
        $m->table='test_table';

        $storage=array();

        $m->setSource('Array', $storage);
        $m['test']=123;
        $m->save(1);

        $m['test']=321;
        $m->save(2);

        $m->load(1);
        return $m['test'];
    }
    function test_source(){
        $m=$this->add('Model');
        $m->addField('test');
        $m->table='test_table';

        $storage=array();

        $m->setSource('Array', $storage);
        $m['test']=123;
        $m->save('foo');

        $m['test']=321;
        $m->save('bar');

        $m->load('foo');
        return json_encode($m->_table);
    }
    function test_id_assigning1(){
        $m=$this->add('Model');
        $m->addField('test');
        $m->table='test_table';

        $storage=array();

        $m->setSource('Array', $storage);
        $m['test']=123;
        $id=$m->save()->id;
        $m->unload();

        $m['test']=321;
        $m->save();

        $m->tryLoad($id);
        return $m->loaded()?json_encode($m->_table):'Unable to get id: '.$id;
    }
    function test_id_assigning2(){
        $m=$this->add('Model');
        $m->id_field='MYID';
        $m->addField('test');
        $m->table='test_table';

        $storage=array();

        $m->setSource('Array', $storage);
        $m['test']=123;
        $id=$m->save('foo')->id;
        $m->unload();

        $m['test']=321;
        $m->save('bar');

        $m->tryLoad($id);
        return $m->loaded()?json_encode($m->_table):'Unable to get id: '.$id;
    }
    function test_id_datatest1(){
        $m=$this->add('Model');
        $m->id_field='MYID';
        $m->addField('test');
        $m->table='test_table';

        $storage=array(
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            array('test'=>'three','MYID'=>'qwe'),
        );

        $m->setSource('Array', $storage);
        return json_encode($m->tryLoad('qwe')->get());
    }
    function test_id_datatest2(){
        $m=$this->add('Model');
        $m->id_field='MYID';
        $m->addField('test');
        $m->table='test_table';

        $storage=array(
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            array('test'=>'one','MYID'=>'abc'),
            array('test'=>'two','MYID'=>'aoeu'),
            'qwe'=>array('test'=>'three','MYID'=>'qwe'),
        );

        $m->setSource('Array', $storage);
        return json_encode($m->tryLoad('qwe')->get());
    }
}

