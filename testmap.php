<?php
include'atk4/loader.php';

class Installer extends ApiInstall {

    function showIntro(){
        $this->add('H1')->set('Welcome to my own installer!');

        parent::showIntro();
    }

    function step_TestMap(){
        $map=$this->add('google/View_Map');//->destroy();
        $this->js(true)->gm()->renderMapWithTimeout($map,500);
    }

    function step_Step_Two(){
        $this->add('LoremIpsum');
    }
}

$api = new Installer('maps');
$api->main();
