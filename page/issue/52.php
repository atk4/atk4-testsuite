<?php
class page_issue_52 extends Page_Tester {
    function prepare(){
    }
    function test_smlite(){
        $res=$this->add('SMLite')->loadTemplateFromString('You have <?vote?>0<?/?> votes left');
        var_dump($res->template);
        return $res->render();
    }
}
