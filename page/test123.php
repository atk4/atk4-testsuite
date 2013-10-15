<?php

class page_test123 extends Page {
    function init(){
        parent::init();

        $this->add('Button')->add('VirtualPage')->bindEvent()
            ->set(function($p){
                $b2=$p->add('Button')->set('Button2');
                if($b2->isClicked()){
                    $b2->js()->univ()->alert('awesome')->execute();
                }
            });
    }
}
