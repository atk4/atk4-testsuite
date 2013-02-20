<?php
class page_authtest extends Page {
    public $tests=4;
    function init(){
        parent::init();


        if($this->add('Button')->setLabel('Init Data')->isClicked()){

            for($i=1;$i<=$this->tests;$i++){
                $m=$this->add('Model_AuthUser'.$i);
                $m->add('dynamic_model/Controller_AutoCreator');
                $m->deleteAll();
                $m->set($m->test_user_field,'demo');
                $m->setPassword('demo');
                $m->saveAndUnload();

            }
            $m=$this->add('Model_AuthUser3');
            $m->set($m->test_user_field,'demo2');
            $m->set('password',md5('demo'));
            $m->saveAndUnload();

            $m->set($m->test_user_field,'demo3');
            $m->set('password','demo');
            $m->saveAndUnload();

            $m->set($m->test_user_field,'demo4');
            $m->set('password',sha1('demo'));
            $m->saveAndUnload();

            $m->set($m->test_user_field,'demo5');
            $key=$this->api->getConfig('auth/key',$this->api->name);
            $m['password']=hash_hmac('sha256',
                'demo'.'demo5',
                $key);
            $m->saveAndUnload();


            $this->js()->univ()->location($this->api->url())->execute();
        }

        if($this->add('Button')->setLabel('Test All')->isClicked()){
            for($i=1;$i<=$this->tests;$i++){
                $m=$this->add('Model_AuthUser'.$i);
                $m->each('test');
            }
            $this->js()->univ()->location($this->api->url())->execute();
        }


        for($i=1;$i<=$this->tests;$i++){
            $m=$this->add('Model_AuthUser'.$i);
            $m->getElement('id')->visible(true);
            $this->add('SturdyCRUD')->setModel($m);
        }


        /*
        // If you want to use whitelist-based auth check, call check() from Frontend.php, init() method
        $auth=$this->add('Auth')->allow('admin','admin')->allow('demo','demo');

        if(!$auth->isLoggedIn()){
            $this->api->add('View_Info')->set('Use "admin / admin" for a test-login');
        }


        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));

        if($_GET['logout']){
            $auth->logout();
            $this->api->redirect();
        }

        $auth->add('auth/Controller_DummyPopup');
        $auth->add('auth/Controller_Cookie');

        $auth->check();

        $this->add('HtmlElement')
            ->setElement('P')
            ->set('Successfully authenticated as '.$auth->get('username'));

        $this->add('Button')->set('Logout')
            ->js('click')->univ()->location($this->api->url(null,array('logout'=>true)));
         */
    }
}
class SturdyCRUD extends CRUD {
    function setModel($m,$a=null,$b=null){
        parent::setModel($m,$a,$b);
        if($this->grid){
            $this->grid->addColumn('button','test');
            if($_GET[$this->grid->name.'_test']){
                $this->grid->model->load($_GET['test'])->test();
                $this->js()->univ()->location($this->api->url())->execute();
            }
        }
    }
    function recursiveRender(){
        try{
            return parent::recursiveRender();
        }catch(BaseException $e){
            $this->output($this->add('View_Error')->set($e->getMessage())->getHTML());
        }
    }
}
