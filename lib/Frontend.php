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
        //$this->add('russian/Controller_Translation');
		$this->add('jUI');
		$this->js()
			->_load('atk4_univ')
			// ->_load('ui.atk4_expander')
			;


		$m=$this->add('Menu',null,'Menu');
		$m->addMenuItem('index','Back');
        $this->dbConnect();
	}
    function _($s){
        if(strpos($s,"\xe2\x80\x8b")!==false){
            throw new BaseException('String passed through _() twice');
        }
        return $s."\xe2\x80\x8b";
    }
    function recursiveRender(){
        $this->page_object->js(true)->fadeIn();
        return parent::recursiveRender();

    }
    function page_index($page){
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
