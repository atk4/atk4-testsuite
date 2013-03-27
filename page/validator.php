<?php
class page_validator extends Page_Tester {
    public $proper_responses=array(
        "Test_empty"=>'OK',
        "Test_int"=>'OK',
        "Test_int2"=>'must be integer​',
        "Test_fail"=>'is incorrect​',
        "Test_eq"=>'OK',
        "Test_eq2"=>'must be equal to {{arg1}}​',
        "Test_eq3"=>'must be equal to {{arg1}}​',
        "Test_ne"=>'must not be {{arg1}}​',
        "Test_ne2"=>'OK',
        "Test_ne3"=>'OK',
        "Test_exa1"=>'Exception: Exception_Logic: Method is not defined for this object​ (class=romaninsh\\validation\\Controller_Validator, method=setSource, arguments=Array) in /Users/rw/Sites/atk42/atk4/lib/AbstractObject.php:795<p id="sample_project_validator_exa1" class="" style=""><a id="sample_project_validator_exa1_view" class="" style="" href="#">More details</a>
        </p>
        '
    );
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
        return $c->now();
    }

}

