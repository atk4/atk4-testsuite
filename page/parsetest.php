<?php
class page_parsetest extends Page {
    public $variances=array();
    public $grid;
    function setVariance($arr){
        $this->variances=$arr;
        foreach($arr as $key=>$item){
            if(is_numeric($key))$key=$item;
            $this->grid->addColumn('html',$key.'_inf',$key.' info');
            $this->grid->addColumn('text',$key.'_res',$key.' result');
        }
    }
    function init(){
        parent::init();
        $this->grid=$this->add('Grid');
        $this->grid->addColumn('text','name');

        $this->setVariance(array('GiTemplate','SMlite'));
        //$this->setVariance(array('Parser2'));
        
        $this->runTests();
    }
    function runTests($test_obj=null){

        if(!$test_obj)$test_obj=$this;

        $tested=array();
        $data=array();
        foreach(get_class_methods($test_obj) as $method){
            $m='';
            if(substr($method,0,5)=='test_'){
                $m=substr($method,5);
            }elseif(substr($method,0,8)=='prepare_'){
                $m=substr($method,8);
            }else continue;

            // Do not retest same function even if it has both prepare and test
            if($tested[$m])continue;$tested[$m]=true;

            // Row contains test result data
            $row=array('name'=>$m);

            foreach($this->variances as $key=>$vari){
                if(is_numeric($key))$key=$vari;

                // Input is a result of preparation function
                if(method_exists($test_obj,'prepare_'.$m)){
                    $input=$test_obj->{'prepare_'.$m}($vari);
                }else{
                    $input=$test_obj->prepare($vari);
                }

                $test_func=method_exists($test_obj,'test_'.$m)?
                    'test_'.$m:'test';

                // Test speed
                $me=memory_get_peak_usage();
                $ms=microtime(true);
                /*
                $limit=20;$hl=round($limit /2);
                for($i=0;$i<$limit;$i++){
                    //$result=call_user_func_array(array($test_obj,$test_func),$input);
                    */
                    $result=$test_obj->$test_func($input[0],$input[1]);
                    //$this->$method($vari);
                    /*
                    if($i==$hl){
                        $meh=memory_get_peak_usage();
                    }
                    */
                //}
                $ms=microtime(true)-$ms;
                $me=($mend=memory_get_peak_usage())-$me;
                $x=$row[$key.'_inf']='Speed: '.round($ms,3).'<br/>Memory: '.$me;

                $x=$row[$key.'_res']=$result;
            }

            $data[]=$row;
        }
        $this->grid->setStaticSource($data);
    }
    function expect($value,$expectation){
        return $value==$expectation?'OK':'ERR';
    }

    function _prepare($t,$str){
        $result='';

        for($i=0;$i<100;$i++){
            $result.=$str;
        }
        return array($this->add($t),$result);
    }

    function prepare($t){
        return array ($this->add($t),'');
        /* return array($this->add($t)->loadTemplateFromString('bla <?name?> name <?/name?> bla bla <?$surname?> bla
           <?middle?> mm <?/?> blah <?outer?> you <?inner?> are <?/?> inside <?/outer?> bobobo'),null); */
    }
    /*
    function prepare_simple($t){
        return array($this->add($t),'bla <?name?> name <?/name?> bla bla <?$surname?> bla <?middle?> mm <?/?> blah <?outer?> you <?inner?> are <?/?> inside <?/outer?> bobobo');
    }
    */
    function test($t,$result){
        $t->loadTemplateFromString($result);
        return $t->render();
    }
    /*
    function test_set($t,$junk){
        $t->set('name','John');
        return $t->render();
    }
    function test_clone($t,$junk){
        $t2=clone $t;
        $t2->set('name','Peter');
        return $t->render();
    }
    function test_clone2($t,$junk){
        $t2=clone $t;
        $t2->set('name','Peter');
        return $t2->render();
    }
    function test_cloneRegion($t,$junk){
        $t2=$t->cloneRegion('outer');
        return $t2->render();
    }
    function prepare_rowrows($t){
        return array($this->add($t)->loadTemplate('grid'));
    }
    function test_rowrows($t,$result){
        var_dump(array_keys($t->tags));
        //var_dump($t->get('rows'));
    }
    */
    function test_content($t){
        $t->loadTemplateFromString('<?foo?> <?bar?> <?foobaz?> <?/?><?/?><?/?>');
        return $t->get('bar');
    }
    function test_gridtpl($t,$result){
        $t->loadTemplate('grid');
    //    var_dump(array_keys($t->tags));
        $t->rebuildTags();
     //   var_dump(array_keys($t->tags));
      //  var_dump($t->template);
        $t=$t->cloneRegion('grid');
        $r=$t->cloneRegion('row');
        /*
        var_Dump($r->template);
        exit;
        */
    }
    function test_each($t){
        $c=0;
        $t->loadTemplate('shared');
        $t->rebuildTags();
        $t->eachTag('template',function($path) use($t){
                return $t->api->locateURL('template',$path);
        });
        //echo $t->render();
        //exit;
        //return $c;

    }

    /*
    function prepare_singletags($t){
        return $this->_prepare($t,'bla <?$hello?> bla ');
    }
    function prepare_empty($t){
        return $this->_prepare($t,'');
    }
    function test($t,$result){
        $t->loadTemplateFromString($result);
        return 'OK';
    }
    */
}
