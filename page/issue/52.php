<?php
class page_issue_52 extends Page_Tester {
   public $proper_responses=array(
        "Test_smlite"=>'You have 0 votes left'
    );
    function prepare(){
    }
    function test_smlite(){
        $res=$this->add('SMLite')->loadTemplateFromString('You have <?vote?>0<?/?> votes left');
        return $res->render();
    }
}
