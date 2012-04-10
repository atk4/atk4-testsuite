<?php
class page_addon extends Page_Tester {
        public $proper_responses=array(
        "Test_adding"=>'helloworld\\Core'
    );
    function prepare(){
        return array($this->add('helloworld/Core'));
    }
    function test_adding($a){
        return get_class($a);
    }
}
