<?php

class page_db4 extends Page_Tester {
    public $db;
    function init(){
        $this->db=$this->add('DB');
        $this->add('View_Info')->set('Testing basic rendering functionality');
        parent::init();
    }
    function prepare(){
        return array($this->db->dsql());
    }
    function formatResult(&$row,$key,$result){
        //parent::formatResult($row,$key,$result);
        $x=parent::formatResult($row,$key,$result);
        if($this->input[0]->params)$row[$key.'_para']=print_r($this->input[0]->params,true);
        return array($x,$this->input[0]->params);
    }
    function test_combi($t){
        $t->table('book')->where('id',1)->set('name','Foo');
        return $t->select().' => '.$t->update();
    }
    function test_join1($t){
        return $t->table('user');
    }
    function test_render2($t){
        return $t->table('user')->join('address');
    }

}
