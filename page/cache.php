<?php
class page_cache extends Page {
    function init(){

        parent::init();
        $this->skipTests('Temporary disabled');

        $this->add('FatView');


        /*
        $mo=$this->add('Model');
        $mo->addField('test');

        $mo['test']='xx';
        $mo->save(123);

         */
    }
}

class FatView extends View {
    function init(){
        parent::init();
        $this->add('Controller_ViewCache');
    }
    function render(){

        sleep(1);
        $this->set(rand(1,100));

        parent::render();
    }
}
