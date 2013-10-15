<?php
class page_validator2 extends Page_Tester {
    function prepare(){
        $m=$this->add('Model_Book');
        $m->set('name','Test Book');
        $m->set('isbn','283');
        $m->c=$m->add('romaninsh/validation/Controller_Validator');
        return array($m);
    }
    function executeTest($test_obj,$test_func,$input){
        try {
            return parent::executeTest($test_obj,$test_func,$input);
        } catch (Exception_ValidityCheck $e) {
            return $e->getField().': '.$e->getMessage();
        }
    }
    function test_empty($m){
        $m->is('name','eq','John')->save();
        return 'OK';
    }
    function test_otherhook($m){
        $m->c->on('other_hook');
        $m->is('name','eq','John')->save();
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

    // Next - tests from the README.md
    function example1($c){
        $c->is(array(
            'name,surname!|len|5..100',
            'addr1_postcode|to_alpha|to_trim|uk_zip?Not a UK postcode',
            'addr2_postcode|if|has_addr1|as|addr1_postcode'
        ));
    }

    function test_exa1(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'John',
            'surname'=>'Smith',
            'addr1_postcode'=>'E3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>'E3 3CZ',
        ));
        $c->now();return'FAIL';
    }

    function test_exa2(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'Stephen',
            'surname'=>'Smith',
            'addr1_postcode'=>'e3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>'E3 3CZ',
        ));
        $c->now();return'FAIL';
    }

    function test_exa3(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'Stephen',
            'surname'=>'',
            'addr1_postcode'=>'e3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>'E3 3CZ',
        ));
        $c->now();return'FAIL';
    }

    function test_exa4(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'Stephen',
            'surname'=>'Hopkins',
            'addr1_postcode'=>'E3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>'E3 3CZ',
        ));
        $c->now();return'OK';
    }
    function test_exa5(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'Stephen',
            'surname'=>'Hopkins',
            'addr1_postcode'=>'E3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>false,
        ));
        $c->now();return'FAIL';
    }
    function test_exa6(){
        $c=$this->add('romaninsh/validation/Controller_Validator');
        $this->example1($c);
        $c->setSource(array(
            'name'=>'Stephen',
            'surname'=>'Hopkins',
            'addr1_postcode'=>'E3 3CZ',
            'has_addr1'=>false,
            'addr2_postcode'=>false,
        ));
        $c->now();return'OK';
    }
}

