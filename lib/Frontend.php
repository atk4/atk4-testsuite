<?php
/*
   Commonly you would want to re-define ApiFrontend for your own application.
 */

class Frontend extends Api_Admin {
	function init(){
		parent::init();



		$this->menu->setModel('testsuite/Collection');
        $this->menu->dest_var='';
	}
    /*
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
     */
}
