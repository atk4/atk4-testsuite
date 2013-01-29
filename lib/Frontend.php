<?php
/*
   Commonly you would want to re-define ApiFrontend for your own application.
 */

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
		$m->addMenuItem('index','Back');
        $this->dbConnect();
	}
    function recursiveRender(){
        $this->page_object->js(true)->fadeIn();
        return parent::recursiveRender();

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
