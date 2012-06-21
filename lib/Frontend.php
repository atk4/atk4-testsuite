<?php
/*
   Commonly you would want to re-define ApiFrontend for your own application.
 */
class Link extends HtmlElement {
    function init(){
        parent::init();
        $this->setElement('a');
    }
    function set($name,$descr){
        $this->setAttr('href',$this->api->getDestinationURL($name));
        return parent::set($descr);
    }
}

class Model_Examples extends Model {
    public $dir;
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('total');
        $this->addField('success');
        $this->addField('fail');
        $this->addField('exception');
        $this->addField('speed');
        $this->addField('memory');
        $this->addField('result');

        $p=$this->api->pathfinder->searchDir('page');
        sort($p);
        $this->setSource('ArrayAssoc',$p);
        $this->addHook('afterLoad',$this);
        return $this;
    }
    function skipped(){
        $this['result']='Skipped';
        return $this;
    }
    function afterLoad(){
        if($this['name']=='authtest.php' ||
            $this['name']=='model1.php' || 
            $this['name']=='modeljoin.php' || 
            $this['name']=='parsetest.php' || 
            $this['name']=='model2.php' 
            )return $this->skipped();

        $page='page_'.str_replace('/','_',str_replace('.php','',$this['name']));
        try {
            $p=$this->api->add($page,array('auto_test'=>false));

            if(!$p instanceof Page_Tester){
                $this['result']='Not Supported';
                return;
            }

            if(!$p->proper_responses){
                $this['result']='No proper responses';
                return;
            }

            $res=$p->silentTest();
            $this->set($res);
            $this['speed']=round($this['speed'],3);
            //list($this['total_tests'], $this['successful'], $this['time']) = 
            $this['result']=$this['success']==$this['total']?'OK':'FAIL';

            $p->destroy();
        }catch(Exception $e){
            $this['result']='Exception: '.$e->getMessage();
            return;
        }



    }

}
class Frontend extends ApiFrontend {
	function init(){
		parent::init();
		$this->addLocation('atk4-addons',array(
					'php'=>array(
                        'mvc',
						'misc/lib',
						)
					))
			->setParent($this->pathfinder->base_location);
        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));
        $this->add('russian/Controller_Translation');
		$this->add('jUI');
		$this->js()
			->_load('atk4_univ')
			// ->_load('ui.atk4_expander')
			;


		$m=$this->add('Menu',null,'Menu');
		$m->addMenuItem('Back','index');
        $this->dbConnect();
	}
    function page_index($page){
        /*
        $page->add('Link')->set('core','AbstractObject');
        $page->add('Link')->set('db','PDO compatible Database Tests');
        $page->add('Link')->set('dbwhere','Where clause testing');
        $page->add('Link')->set('dbparam','Parametric arguments and subqueries');

        $this->add('Grid')->setModel('Examples');
         */
        $m=$this->add('Model_Examples');
        $l=$this->add('Grid');
        $l->setModel('Examples');
        $l->addTotals();
        $l->addHook('formatRow',function($l){
            $n=$l->current_row['name'];
            $n=str_replace('.php','',$n);
            $n='<a href="'.$l->api->url($n).'">'.$n.'</a>';

            $l->current_row_html['name']=$n;
        });
    }
}
