<?php
include'atk4/loader.php';

class Installer extends ApiInstall {

    function showIntro(){
        $this->add('H1')->set('Welcome to my own installer!');

        parent::showIntro();
    }

    function step_TestMap(){
        $map=$this->add('google/View_Map');//->destroy();
        $map->setCenter('51.5081289','-0.128005');
        $map->_renderMapJs('render_map');
        $this->js(true)->gm()->renderMapWithTimeout($map,500);

        $b=$this->add('Button');
        $b->add('misc/PageInFrame')->bindEvent('click','Frame Title')->set(function($page){
            $map=$page->add('google/View_Map');//->destroy();
            $map->setCenter('51.5081289','-0.128005');
            $map->_renderMapJs('render_map');
            $this->js(true)->gm()->renderMapWithTimeout($map,500);
        });
    }

    function step_Step_Two(){
        $this->add('LoremIpsum');
    }
}

$api = new Installer('maps');
$api->main();
