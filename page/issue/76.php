<?php
class page_issue_76 extends Page {
	function init(){
		parent::init();
		
		$c = $this->add('CRUD',array('name','email','password'));
		$m = $c->setModel('Example');
		if($c->grid) {
			$c->grid->addPaginator(3);
			$c->grid->addQuickSearch(array('name')); // I know I can put array('first_name','last_name') here in this case, but this is just an example
		}
		$m->debug();

	}
}

class Model_Example extends Model_Table {
	public $table = 'user';
	
	function init(){
		parent::init();
		$this->addField('email');
		$this->addField('password');
		$this->addField('name');
		$this->addExpression('name')->set('concat(email," ",password)');
	}
}
