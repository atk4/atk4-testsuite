<?php
class Model_Examples extends Model {
    public $dir;
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('total');
        $this->addField('success');
        $this->addField('fail');
        $this->addField('exception');
        $this->addField('speed');
        $this->addField('memory');
        $this->addField('result');

        $p=$this->api->pathfinder->searchDir('page');
        sort($p);
        $this->setSource('ArrayAssoc',$p);
        $this->addHook('afterLoad',$this);

        return $this;
    }
    function skipped(){
        $this['result']='Skipped';
        return $this;
    }
    function afterLoad(){
        if($this['name']=='authtest.php' ||
            $this['name']=='authcustom.php' || 
            substr($this['name'],0,2) =='ui' ||
            $this['name']=='model1.php' || 
            $this['name']=='modeljoin.php' || 
            $this['name']=='parsetest.php' || 
            $this['name']=='model2.php' 
            )return $this->skipped();

        $page='page_'.str_replace('/','_',str_replace('.php','',$this['name']));
        try {
            $p=$this->api->add($page,array('auto_test'=>false));

            if(!$p instanceof Page_Tester){
                $this['result']='Not Supported';
                return;
            }

            if(!$p->proper_responses){
                $this['result']='No proper responses';
                return;
            }

            $res=$p->silentTest();
            $this->set($res);
            $this['speed']=round($this['speed'],3);
            //list($this['total_tests'], $this['successful'], $this['time']) = 
            $this['result']=$this['success']==$this['total']?'OK':'FAIL';

            $p->destroy();
        }catch(Exception $e){
            $this['result']='Exception: '.$e->getMessage();
            return;
        }



    }

}
