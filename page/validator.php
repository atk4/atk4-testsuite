<?php
class page_validator extends Page_Tester {
    function prepare(){
        $m=$this->add('Model_Book');
        $m->tryLoadBy('name','Test Book');
        $m->set('name','Test Book');
        $m->c=$m->add('romaninsh/validation/Controller_Validator');
        return array($m);
    }
    function test_empty($m){
        return $m->set('isbn',123)->save()->get('isbn');
    }
    function test_int($m){
        $m->c->configure('beforeSave',array('isbn'=>'int!'));
        return $m->set('isbn','foo')->save()->get('isbn');
    }
    function test_int2($m){
        $m->c->configure('beforeSave',array('isbn'=>'int'));
        return $m->set('isbn','foo')->save()->get('isbn');
    }
}

