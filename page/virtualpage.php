<?php
class page_virtualpage extends Page {
    function page_index(){
        $t=$this->add('Tabs');
        $t->addTabURL('./forminpage');
        $t->addTabURL('./twoforms');
    }
    function page_forminpage(){
        parent::init();


        $this->add('Button')->set('Import')
            ->add('VirtualPage')
            ->bindEvent('Import','click')
            ->set(function($page){
                $f = $page->add('Form');
                $f->addField('text','notes')->set($page->api->url());
                $f->addSubmit('Import');

                $f->onSubmit(function($form){ // <-- this never gets executed
                    $a = $form->get();
                    $a = var_export($a,true);
                    $form->js()->univ()->successMessage('It works: '.$a)->execute();
                });
            });

    }
    function page_twoforms(){
        $m = $this->add("Model_Book");
        $this->add("CRUD")->setModel($m);
        $f=$this->add("Form");
        $f->setModel($m);
        $f->addSubmit();
        if ($f->isSubmitted()) {
            $f->js()->univ()->alert($f->getModel()->loaded())->execute();
        }

    }
}
