<?php

class page_tabs extends Page_Tester {
    function prepare(){
        return array($this->add('Tabs'));
    }
    function test_empty($t){
        return $t->destroy();
    }

    function test_html2($t){
        return $t->getHTML();
    }

    function test_adding($t){
        $t->addTab('foo');
        $t->addTab('bar');
        return $t->getHTML();
    }
}

