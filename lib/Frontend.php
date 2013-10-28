<?php
/*
   Commonly you would want to re-define ApiFrontend for your own application.
 */

class Frontend extends ApiFrontend {
	function init(){
		parent::init();

        $this->add('jUI');

		$this->menu=$m=$this->add('Menu',null,'Menu');
		$m->addMenuItem('index','Back');
        $this->dbConnect();
	}
    function page_index($page){
        $l = $this->add('Grid');
        $l->setModel('AgileTest');
        $l->addTotals()->setTotalsTitle('name', '%s test%s');
        
        $l->addHook('formatRow', function($l){
            $n = $l->current_row['name'];
            $n = str_replace('.php', '', $n);
            $n = '<a href="'.$l->api->url($n).'">'.$n.'</a>';
            $l->current_row_html['name'] = $n;
        });
    }
}
