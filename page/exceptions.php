<?php
class page_exceptions extends Page_Tester {
    public $proper_responses=array(
            "Test_exception1"=>'Proper Exception​',
            "Test_exception2"=>'Exception_ForUser',
            "Test_exception3"=>'Exception_Logic_test',
            "Test_moreinfo1"=>'',
            "Test_htmloutput"=>'Exception: Exception_ForUser: Unable to access file​ (filename=testfile.txt) in /Users/rw/Sites/atk42/atk4-testsuite/page/exceptions.php:52<p id="sample_project_exceptions_htmloutput" class="" style=""><a id="sample_project_exceptions_htmloutput_view" class="" style="" href="#">More details</a>
</p>
'
        );
    function prepare(){
        return array();
    }

    function test_exception1(){
        try{
            throw $this->exception('Proper Exception');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    function test_exception2(){
        $c=$this->add('Controller');
        $c->default_exception='Exception_ForUser';

        try{
            throw $c->exception('Proper Exception');
        }catch(Exception $e){
            return get_class($e);
        }
    }
    function test_exception3(){
        $c=$this->add('Controller');
        $c->default_exception='Exception_Logic';

        try{
            throw $c->exception('Proper Exception','_test');
        }catch(Exception $e){
            return get_class($e);
        }
    }
    function test_moreinfo1(){
        try{
            throw $this->exception('Proper Exception','Exception_ForUser')
                ->addMoreInfo('foo','bar');
        }catch(Exception $e){
           // return $e->getHTML();
        }
    }
    function test_htmloutput(){
        throw $this->exception('Unable to access file',null,'13')
            ->addMoreInfo('filename','testfile.txt');
    }
}
class Exception_Logic_test extends Exception_Logic {}
