<?php

class page_logger extends Page {
    public $default_exception='Exception_Logic';
    function init(){
        parent::init();

        if($_GET['ex']){
            throw $this->exception('test exception');
        }

        $this->add('Button')->set('Error on page')->link(null,array('ex'=>true));

        $this->add('Button')->set('Error in popup')->js('click')->univ()->frameURL($this->api->url(null,array('ex'=>true)));

        $this->add('Button')->set('Error in ajax')->js('click')->univ()->ajaxec($this->api->url(null,array('ex'=>true)));

        $f=$this->add('Form');
        $f->addSubmit('Error in Form');
        $f->onSubmit(function($f){
            throw $f->exception('test exception');
        });
    }
}
