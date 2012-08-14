<?php
class page_authcustom extends Page {
	function init(){
		parent::init();

		$m=$this->add('Model');
		
        $auth=$this->add('Auth')->allow('admin','admin')->allow('demo','demo');

        if(!$auth->isLoggedIn()){
            $this->add('View_Info')->set('Use "admin / admin" for a test-login');
        }

        if($_GET['logout']){
            $auth->logout();
            $this->api->redirect();
        }

        if(!$auth->isLoggedIn()){
        	$form=$this->add('Form');
        	$form->addField('line','secret');
        	return;
        }


        

        $this->add('HtmlElement')
            ->setElement('P')
            ->set('Successfully authenticated as '.$auth->get('username'));

        $this->add('Button')->set('Logout')
            ->js('click')->univ()->location($this->api->url(null,array('logout'=>true)));



	}
}