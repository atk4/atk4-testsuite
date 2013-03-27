<?php
class page_validator extends Page_Tester {
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
            return $e->getMessage();
        }
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

    // Next - tests from the README.md
    function example1($m){
        $m->c->is(array(
            'name,surname!|len|5..100',
            'addr1_postcode|to_alpha|to_trim|uk_zip?Not a UK postcode',
            'addr2_postcode|if|has_addr1|as|addr1_postcode'
        ))->now();
        //$m->hook('beforeSave');
    }

    function test_exa1($m){
        $d=array(
            'name'=>'John',
            'surname'=>'Smith',
            'addr1_postcode'=>'E3 3CZ',
            'has_addr1'=>true,
            'addr2_postcode'=>'E3 3CZ',
        );
        $this->example1($m);
    }

}

