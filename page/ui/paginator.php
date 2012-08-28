<?php
class page_ui_paginator extends Page {
	function init(){
		parent::init();
		
		$tt=$this->add('Tabs');
		$tt->addTab('Grid')->add('Grid')->setModel('MyModel')->owner->addPaginator(5);
		$cl=$tt->addTab('CompleteLister')->add('CompleteLister');
		$cl->setModel('MyModel');
		$cl->add('Paginator',null,'Content')->ipp(5);
	}
}
class Model_MyModel extends Model_Table {
    public $table='user';
    function init(){
        parent::init();

        $this->addField('name')->defaultValue('John');

        $this->addExpression('age')->set(function(){
            return 123;
        });

    }
}
