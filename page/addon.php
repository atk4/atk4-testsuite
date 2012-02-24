<?php
class page_addon extends Page_Tester {
    public $proper_responses=array(
        "Test_adding"=>'sample_project_addon_helloworld\\core'
    );
    function prepare(){
        return array($this->add('helloworld\Core'));
    }
    function test_adding($a){
        return $a->name;
    }
}
