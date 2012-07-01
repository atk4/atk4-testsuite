<?php
class page_issue_60 extends Page {
	function init(){
		parent::init();
		
		$this->add('Text',null,'TestSpot')
		->set('This is a Text object');

		$this->add('P',null,'TestSpot')
		->set('This is a P element');

		$this->add('H1',null,'TestSpot')
		->set('This is a H1 heading.');

		$this->add('Button',null,'TestSpot')
		->set('This is a Button');

        // placed before TestSpot <div>
		$this->add('Text',null,'TestSpot')
		->set('This is the second Text object');


		$this->add('HtmlElement',null,'TestSpot')
		->setElement('a')
		->set('This is a link')
		;

	}
	function defaultTemplate(){
		return array('page/issue/60');
	}
}