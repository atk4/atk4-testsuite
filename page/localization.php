<?php
class page_localization extends Page_Tester {
    public $proper_responses=array(
        "Test_basic"=>'Postfixed',
        "Test_double"=>'Exception: BaseException: String passed through _() twice () in /Users/rw/Sites/atk42/atk4-testsuite/page/localization.php:13<p id="sample_project_localization_double" class="" style=""><a id="sample_project_localization_double_view" class="" style="" href="#">More details</a>
</p>
'
        );
    function test_basic(){
        return 'test'===$this->api->_('test')?'Unchanged':'Postfixed';
    }
    function test_double(){
        return $this->api->_($this->api->_('test'));
    }
}
