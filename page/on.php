<?php

class page_on extends Page {
    function page_index(){
        $this->add('Text')->setHTML('<a href="'.$this->api->url('./test').'">google?</a>');

        $this->on('click','a')->univ()->frameURL(
            "Wine Wizards: Producer Details",
            $this->js()->_selectorThis()->attr('href'),
        array('width' => '750px')
        );
    }
    function page_test(){
        $this->add('HelloWorld');
    }
}
