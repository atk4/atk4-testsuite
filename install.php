<?php

// DO NOT ADD ANYTHING TO THIS FILE!!

// This is a catch-all file for your project. You can change
// some of the values here, which are going to have affect
// on your project

// AgileProject - change to your own API name.
// agile_project - this is realm. It should be unique per-project
// jui - this is theme. Keep it jui unless you want to make your own theme

include '../atk4/loader.php';

class ApiInstall extends ApiWeb {
    function init(){
        parent::init();

        $this->page=null;
        $this->saved_base_path = $this->pm->base_path;
        $this->pm->base_path.=basename($_SERVER["SCRIPT_NAME"]);

        $this->add('jUI');

        $this->template->trySet('version','Web Software Installer');

        $this->stickyGET('step');

        $this->s_first=$this->s_last=$this->s_current=$this->s_prev=$this->s_next=null;
        $this->s_cnt=0;

        $m=$this->add('Menu',null,'Menu');

        foreach(get_class_methods($this) as $method){
            list($a,$method)=explode('step_',$method); if(!$method)continue;
            //var_dump($method);

            if(is_null($this->s_first))$this->s_first=$method;
            $this->s_last=$method;

            $u=$this->url(null,array('step'=>$method));
            $this->page=$this->pm->base_path.'?step='.$_GET['step'];
            $m->addMenuItem($u,ucwords(strtr($method,'_',' ')));
            $this->page=null;

            if(is_null($this->s_current)){
                $this->s_cnt++;
                if($method==$_GET['step']){
                    $this->s_current=$method;
                    $this->s_title=ucwords(strtr($method,'_',' '));
                }else{
                    $this->s_prev=$method;
                }
            }else{
                if(is_null($this->s_next))$this->s_next=$method;
            }


        }
        if(!$_GET['step']){
            return $this->showIntro();
        }

        $this->initStep($this->s_current);
    }
    function initStep($step){
        //var_dump($this->s_first,$this->s_prev,$this->s_current,$this->s_next,$this->s_last);
        //echo $this->url(null,array('step'=>$this->s_first));
        $step='step_'.$step;
        if(!$this->hasMethod($step))return $this->add('H1')->set('No such step');
        $this->header=$this->add('H1')->set('Step '.$this->s_cnt.': '.$this->s_title);
        return $this->$step();
    }
    function showIntro(){
        $this->add('H1')->set('Welcome to Web Software');
        $this->add('P')->set('Thank you for downloading this software. This wizard will guide you through the installation procedure.');

        if(!is_writable('.') ){
            $this->add('View_Warning')->setHTML('This installation does not have permissions to create your <b>config.php</b> file for you. You will need to manually create this file');
        }elseif(file_exists('config.php')){
            $this->add('View_Warning')->setHTML('It appears that you alerady have <b>config.php</b> file in your applicaiton folder. This installation will read defaults from config.php, but it will ultimatelly <b>overwrite</b> it with the new settings.');
        }

        $this->add('Button')->set('Start')->js('click')->univ()->location($this->stepURL('first'));
    }
    function stepURL($position){
        $s='s_'.$position;
        $s=$this->$s;
        return $this->url(null,array('step'=>$s));
    }
}

class Install extends ApiInstall {
    function init(){
        parent::init();
        $this->requires('atk','4.2.2');

        if($dsn=$this->recall('dsn',false)){
            $this->dbConnect($dsn);
        }
    }
    function step_requirements(){
        $checks=array(
            array('PHP Version 5.3+',function($a){ return "OK"; }),
            array('Suhosin Settings',function($a){ return "OK"; }),
            array('CURL (for API access)',function($a){ return function_exists('curl_open'); }),
            array('Detected URL for this application',function($a){ return $a->pm->base_url.$a->saved_base_path; }),
            array('Base Folder',function($a){ return $a->getConfig('atk/base_path'); }),
        );

        $results=array();
        foreach($checks as $row){
            $r=array('name'=>$row[0]);
            $r['result']=call_user_func($row[1],$this);
            $results[]=$r;
        }
        $g=$this->add('Grid');
        $g->addColumn('name');
        $g->addColumn('result');

        $g->setSource($results);
        $g->model->addCache('Dumper');

        

        $this->add('Button')->setHTML('Next &raquo;')->js('click')->univ()->location($this->stepURL('next'));
    }
    function step_database_config(){
        $this->add('P')->set('DSN allows your application to connect to your database. The DSN can be formatted either as a PEAR::DB compatible DSN or as a PDO DSN.');
        $f=$this->add('Form');
        $f->addClass('stacked');
        $f->addField('line','dsn')->set($this->recall('dsn',$this->getConfig('dsn')));
        $f->addButton('Back')->js('click')->univ()->location($this->stepURL('prev'));
        $f->addSubmit('Test and Continue');
        if($f->isSubmitted()){
            $dsn=$f->get('dsn');
            try{
                $this->add('DB')->connect($dsn);
            }catch(Exception $e){
                $f->error('dsn',$e->getMessage());
            }
            $this->memorize('dsn',$dsn);
            $this->js()->univ()->location($this->stepURL('next'))->execute();
        }
    }
    function step_features(){
        $this->add('P')->set('You can customize your installation to use mod_rewrite for a pretty URLs and enable some other features.');
        $f=$this->add('Form');
        $f->addClass('stacked');
        $ff=$f->addField('checkbox','seo','Enable pretty URLs')->set(!$this->getConfig('url_prefix'));

        $ff->belowField()->add('View')->setElement('a')
            ->set('Test your .htaccess settings')
            ->setAttr('target','_blank')
            ->setAttr('href','#')
            ->js('click')->univ()->newWindow($this->api->pm->base_url.$this->api->saved_base_path.'playground',
            'test','width=500,height=600');

        $f->addField('checkbox','logging','Enable logging into file')->set(!!$this->getConfig('logger/log_output',false));
        $f->addField('checkbox','logging','Do not show error messages to user')->set(!$this->getConfig('logger/web_output',true));

        $f->set($this->recall('features',array()));

        $f->addButton('Back')->js('click')->univ()->location($this->stepURL('prev'));
        if($f->addButton('Reset to Defaults')->isClicked()){
            $this->forget('features');
            $this->js()->univ()->location($this->stepURL('current'))->execute();
        }
        $f->addSubmit('Save and Continue');
        if($f->isSubmitted()){
            $this->memorize('features',$f->get());
            $this->js()->univ()->location($this->stepURL('next'))->execute();
        }
    }
    function step_license(){

        $this->add('P')->set('You need to select which license to use with Agile Toolkit. If you are willing to use Agile Toolkit for free under an open-source licenes, you must use AGPL license for your code too. '
            .'This installer allow you to register for open-source license or purchase a closed-source license.');

        $acc=$this->add('Model_AgileToolkit_Access');     // Credentials of Agile Toolkit.org
        $lic=$this->add('Model_AgileToolkit_Licenses');   // API for interacting on licenses
        $f=$this->add('Form');


        $acc->tryLoadAny();     // will try to connect to AgileToolkit

        $acc['email']='romans';
        $acc['password']='test';
        $acc->auth();

        var_Dump($_SESSION);

        if(!$acc->loaded()){
            $f->add('H2')->set('Access credentials for agiletoolkit.org');
            $f->setModel($acc);
            $f->addSubmit()->set('Authenticate');

            // Authenticate
            if($f->isSubmitted()){
                $f->update();
                $f->js()->univ()->alert('Authenticated');
            }
        }

        /*
        $f->add('H2')->set('Access credentials for agiletoolkit.org');
        $f->setModel($lic);
         */


    }
    function step_migration(){
        $mig=$this->add('Controller_DatabaseMigration');
        $results = $mig->executeMigrations();

        $g=$this->add('Grid');
        $g->addColumn('name');
        $g->addColumn('result');

        $g->setSource($results);

        $f=$this->add('Form');
        $f->addClass('stacked');
        $f->addButton('Retry')->js('click')->univ()->location($this->stepURL('current'));
        $f->addButton('')->setHTML('Next &raquo;')->js('click')->univ()->location($this->stepURL('next'));
    }
    function step_addons(){
        $mig=$this->add('Model_AgileToolkit_Addons');     // fetches add-on information from agiletoolkit.org

        $g=$this->add('Grid');
        $g->setModel($mig);
        $g->addColumn('button','install');
    }
    function step_finish(){
    }
}



$api=new Install('sample_project');
$api->main();

