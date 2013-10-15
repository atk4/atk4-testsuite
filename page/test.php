<?php
class page_test extends dynamic_model\Page_DynamicAdmin {
    function init(){
        parent::init();

        $cc=$this->add('Columns');
        $c=$cc->addColumn(4);

        $f=$c->add('Frame')->add('Form');
        $f->setClass('stacked');
        $f->setModel('Author')->tryLoadAny();
        $f->addSubmit('Save');
        $f->addSubmit('Edit Books');
        return;


        $this->setModel('Book');
        return;
        $dumper = $this->add('dynamic_model/Controller_ModelDumper');
        $dumper->setModel('Book');
        echo '<pre>';
        $dumper->dump();
        exit;
    }
}
