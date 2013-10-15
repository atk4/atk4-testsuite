<?php


class page_url extends Page_Tester {
    function init(){
        $this->api->pm->base_path='/';
        parent::init();
        // for consistent test results
    }
    function test_compat(){
        $url=$this->api->url();
        return $url;
    }
    function test_url1(){
        $url=$this->api->url('test');
        return $url;
    }
    function test_url2(){
        $url=$this->api->url('/test');
        return $url;
    }
    function test_url3(){
        $url=$this->api->url('./test');
        return $url;
    }
    function test_url4(){
        $url=$this->api->url('../test');
        return $url;
    }
    function test_sticky1(){
        $_GET['x']=123;
        $this->api->stickyGET('x');
        $url=$this->api->url('test');
        return $url;
    }
    function test_sticky2(){
        $_GET['x']=321;
        $url=$this->api->url('test');
        return $url;
    }
    function test_sticky3(){
        $url=$this->api->url('test',array('x'=>432));
        return $url;
    }
    function test_sticky4(){
        $url=$this->api->url('test',array('y'=>432));
        return $url;
    }
    function test_sticky_11(){
        $this->api->stickyForget('x');
        $url=(string)$this->api->url('test');
        return $url;
    }
    function test_sticky_12(){
        $_GET['x']=11;
        $this->api->stickyGET('x');
        $url=$this->api->url('test');
        $this->api->stickyForget('x');
        return (string)$url;
    }

    // New functionality - local URLs
    function test_localsticky1(){

        $this->view=$this->add('View');
        $_GET['z']='loc';
        $this->view->stickyGET('z');
        $this->api->stickyGET('x');

        $url=$this->api->url('test');
        return $url;
    }

    function test_localsticky2(){
        $url=$this->view->url('test');
        return $url;
    }
    function test_localsticky3(){
        $url=$this->page->url('test');
        return $url;
    }
}

