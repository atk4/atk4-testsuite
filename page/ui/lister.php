<?php
class page_lister extends Page {
	function init(){
		parent::init();

		$page=$this;
		

		$page->add('Lister')
			->setSource(array('One','Two','Three'));


		$page->add('Lister')
		->setSource(array(
			5=>'John',
			7=>'Steve'
			));


		$grid=$page->add('Grid');
		$grid->addColumn('text','id');	// THIS WILL NOT SHOW THE ID GIVING IN THE ARRAY BELOW!!!! 

		$grid->setStaticSource(array(
			array('id'=>5,'name'=>'John','details'=>'John Details'),
			array('id'=>9,'name'=>'Peter','details'=>'Peter Details'),
			));

		$grid->addColumn('link','details');



	}
}