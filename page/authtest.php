<?php
class page_authtest extends Page {
    function init(){
        parent::init();

        // If you want to use whitelist-based auth check, call check() from Frontend.php, init() method
        $auth=$this->add('Auth')->allow('admin','admin');

        if(!$auth->isLoggedIn()){
            $this->api->add('View_Info')->set('Use "admin / admin" for a test-login');
        }


        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));

        if($_GET['logout']){
            $auth->logout();
            $this->api->redirect();
        }

        $auth->add('auth/Controller_DummyPopup');

        $auth->check();

        $this->add('HtmlElement')
            ->setElement('P')
            ->set('Successfully authenticated as '.$auth->get('username'));

        $this->add('Button')->set('Logout')
            ->js('click')->univ()->location($this->api->url(null,array('logout'=>true)));
    }
}
