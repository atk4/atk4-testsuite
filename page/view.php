<?php

class MyInvisible extends AbstractView {
    function recursiveRender(){
    }
}

class page_view extends Page_Tester {
        public $proper_responses=array(
        "Test_empty"=>'<p>Hello world</p>',
        "Test_frame"=>'
<div id="sample_project_view_myinvisible_test_frame_frame" class="rounded ui-widget-content ui-corner-all atk-box white " style="">
  <h2>FrameTitle</h2>
  <p>Hello world</p>
</div>
'
    );
    function init(){
        $this->i=$this->add('MyInvisible');
        parent::init();
        $this->i->destroy();
    }
    function prepare($junk,$method){
        return array($this->i->add('View',$method));
    }
    function test_empty($t){
        $x=$t->add('HelloWorld');
        return $x->getHTML();
    }
    function test_frame($t){
        $this->api->add('Controller_Compat','compat');

        $x=$t->add('Frame')->setTitle('FrameTitle');
        $x->add('HelloWorld');
        return $x->getHTML();
    }
    function test_lister($t){
        $s3 = array(
            array('a'=>1,'b'=>'John','name'=>'Smith'),
            array('a'=>2,'b'=>'Joe','name'=>'Blogs')
        );
        $l=$this->add('Lister');
        $l->setSource($s3);
        return $l->getHTML();
    }
    function test_lister2($t){
        $s3 = array(
            'Smith','Blogs'
        );
        $l=$this->add('Lister');
        $l->setSource($s3);
        return $l->getHTML();
    }

}

