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
    function test_fail($m){
        $m->c->is('name|fail')->now();
        return 'FAIL';
    }
    function test_eq($m){
        $m->c->is('name|eq|name')->now();
        return 'OK';
    }
    function test_eq2($m){
        $m->c->is('name|eq|isbn')->now();
        return 'OK';
    }
    function test_eq3($m){
        $m->c->is('name|same:isbn')->now();
        return 'OK';
    }
    function test_ne($m){
        $m->c->is('name|ne|name')->now();
        return 'OK';
    }
    function test_ne2($m){
        $m->c->is('name|ne|isbn')->now();
        return 'OK';
    }
    function test_ne3($m){
        $m->c->is('name|different:isbn')->now();
        return 'OK';
    }
}

