<?php

class Model_X extends Model_Table {
    public $entity_code='x';
    function init(){
        parent::init();
        $this->addField('foo')->mandatory(true);
    }
}

class page_form extends Page_UITest {
    function init(){
        parent::init();

    }
    function test_buttonclicks(){
        $f=$this->add('Form');
        $a=$f->addSubmit('John Doe');
        $b=$f->addSubmit('b');
        if($f->isSubmitted()){
            if($f->isClicked($a)){
                $this->js()->univ()->alert('John Doe clicked')->execute();
                $this->add('View_Info')->set('John Doe clicked');
            }
            if($f->isClicked('b')){
                $this->js()->univ()->alert('b clicked')->execute();
                $this->add('View_Info')->set('b clicked');
            }
        }
    }
    function test_textarea(){
        $this->add('Form')->addField('text','test');
    }
    function test_setmodel(){
        $this->add('MVCForm')->setModel('X');
    }
    function test_autocomplete(){
        $cc=$this->add('Columns');
        $cc->addColumn(6)->add('Form')->setModel('Book');
        $m=$this->add('Model_Book');
        //$m->getField('author_id')->display('autocomplete');
        $cc->addColumn(6)->add('Form')->setModel($m);
    }

}
