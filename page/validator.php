<?php
class page_validator extends Page_Tester {
    function prepare(){
        $m=$this->add('Model_Book');
        $m->set('name','Test Book');
        $m->set('isbn','283');
        $m->c=$m->add('romaninsh/validation/Controller_Validator');
        return array($m);
    }
    function test_empty($m){
        $m->c->now();
        return 'OK';
    }
    function test_int($m){
        $m->c->is('isbn|int')->now();
        return 'OK';
    }
    function test_int2($m){
        $m->c->is('name|int')->now();
        return 'FAIL';
    }
}

