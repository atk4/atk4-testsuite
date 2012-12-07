<?php
class page_modelcache extends Page_Tester {
    function prepare(){
        $m=$this->add('Model');

        $m->addField('test');
        $m->table='test_table';

        $storage=array();

        $m->setSource('Dumper');
        $m->controller->setPrimarySource($m,'Array',$storage);

        return array($m);

    }

    function test_direct($m){

        $m['test']=123;
        $m->save(1);

        $m['test']=321;
        $m->save(2);

        $m->load(1);
        return join("<br/>\n",$m->controller->getLog());
    }
    function test_cache1($m){
        $cache = $m->addCache('Dumper','zz');
        $cache->setPrimarySource($m,'Array');

        $m['test']='first';
        $m->save(1);

        $m['test']='second';
        $m->save(2);

        $m->load(1);
        return join("<br/>\n",$m->controller->getLog()).'<br/>=CACHE=<br/>'.join("<br/>\n",$cache->getLog());
    }
    function test_cache1a($m){

        $m['test']='first';
        $m->save(1);

        $cache = $m->addCache('Dumper','zz');
        $cache->setPrimarySource($m,'Array');

        $m['test']='second';
        $m->save(2);

        $m->load(1);
        return join("<br/>\n",$m->controller->getLog()).'<br/>=CACHE=<br/>'.join("<br/>\n",$cache->getLog());
    }
    function test_cache2($m){
        $cache = $m->addCache('Dumper','zz');
        $cache->setPrimarySource($m,'Array');

        $m['test']=123;
        $m->save(1);

        $m['test']=321;
        $m->save(2);

        $m->load(1);
        return json_encode($m->_table);
    }
}
