<?php
include'vendor/autoload.php';

$api = new ApiCLI();
$api->add('Logger');

try {

    echo'<pre>';
    //$temp=$api->add('SMLite');
    $temp=$api->add('GiTemplate');

    //$temp->loadTemplateFromString('be {huj} fo {_one} bt {$two} at  {/_one}{one}{two}{$three}{/two}{/}{/huj}');
    //$temp->loadTemplateFromString('before {Menu} after {/Menu} three {Content} four {/Content} z {aa} zzz {/aa} qqq');
    //$temp->loadTemplateFromString('{p}Agile{/p} {_top}ui{/_top}i oeu');
    //$temp->loadTemplateFromString('{lang}en{/}{page_title}Agile Toolkit - Untitled Project{/page_title} {$page_description} {css}ui-lightness/jquery-ui-1.10.3.custom.min.css{/} {css}main.css{/}"> {$js_include}  {$document_ready} {$pagename} ome Frame</a> to ove your experience.</p> < ![endif]-->{Layout} <div class="atk-layout"> <div class="atk-layout-row"> <header id="atk-header" class="giga">AgileToolkit 4.3 &ndash; <strong>Snippets</strong></header> </div>{$Menu} <div id="atk-main" class="atk-layout-row fluid"> <div id="atk-main-inner" class="atk-layout"> <div id="atk-content" class="atk-layout-column flyid">{$Content}</div> </div> </div> <div class="atk-layout-row"> <footer id="atk-footer">&copy; Agile Toolkit 2013</footer> </div> </div>{/} </body> </html>');
    $temp->loadTemplate('shared');
    //$temp->loadTemplateFromString('{one}{two}{/two}{/}');
    $temp->dumpTags();


    $q=$temp->cloneRegion('Layout');
    $q->set('Menu','Hello');
    $q->dumpTags();




    exit;
}catch(Exception $e) {
    $api->caughtException($e);
}


$api->pathfinder->base_location->defineContents(array('addons'=>'vendor'));

$api->add('Logger');
$api->add('atk4/atk4-tests/Controller');

try {
    $testsets = $api->add('testsuite/Model_Collection');
    $testsets->load('af-test');

    $testsets->runTests();
}catch(Exception $e) {
    $api->caughtException($e);
}


