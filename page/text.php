<?php
class page_text extends Page {
	function init(){
		parent::init();

		$f=$this->add('Form');
		$ff=$f->addField('line','test');

		$g=$this->add('Grid');

		$g->addClass('zebra bordered');

		$this->js(true)->show();


		$g->addColumn('test');
		$g->addColumn('expander','expander');
		$g->addColumn('expander','test');
		$g->setSource(array(array(),array()));
		$g->addSelectable($ff);
		$g->js(true)->find('tbody')->selectable('option','cancel',':input,option,label');


		$this->add('Text')->set('German like ä, ü, ö should be visible');

		$m=$this->add('TestModel');
		$m['name']='Joh<b>n
		X';
		$m['surname']='Blo<b>gs';
		$m['text']='he<b>llo
		
World';
		$m['descr']='he<b>llo
		
World';
		$this->add('View',null,null,array('view/texttest'))
			->setModel($m,array('test'));
		
	}
}

class TestModel extends Model {
	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('surname');
		$this->addField('bio')->type('text');
		$this->addField('descr')->type('text')->allowHtml(true);
	}
}