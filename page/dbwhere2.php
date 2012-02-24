<?php

class page_dbwhere2 extends Page_Tester {
    public $db;
    public $proper_responses=array(
        "Test_where_or1"=>array (
  0 => 'select  * from `foo`  where (i is null or o is null)    ',
  1 => 
  array (
  ),
),
        "Test_where_or2"=>array (
  0 => 'select  * from `foo`  where (i is null or o is null)    ',
  1 => 
  array (
  ),
),
        "Test_where_or3"=>array (
  0 => 'select  * from `foo`  where (`x` = (select  * from `foo`      ) or o is null)    ',
  1 => 
  array (
  ),
),
        "Test_where_or4"=>array (
  0 => 'select  * from `foo`  where (`i` = :a or `o` = :a_2)    ',
  1 => 
  array (
    ':a' => NULL,
    ':a_2' => NULL,
  ),
)
    );
    function init(){
        $this->db=$this->add('DB');
        parent::init();
    }
    function runTests(){
        $this->grid->addColumn('text','Test_para');
        return parent::runTests();
    }
    function formatResult(&$row,$key,$result){
        //parent::formatResult($row,$key,$result);
        $x=parent::formatResult($row,$key,array($result,$this->input[0]->params));
        return $x;
    }
    function prepare(){
        return array($this->db->dsql()->table('foo'));
    }
    function test_where_or1($t){
        return $t->where(array('i is null','o is null'));
    }
    function test_where_or2($t){
        return $t->where(array($t->expr('i is null'),$t->expr('o is null')));
    }
    function test_where_or3($t){
        return $t->where(array(array('x',$t->dsql()->table('foo')),$t->expr('o is null')));
    }
    function test_where_or4($t){
        return $t->where($t->orExpr()->where('i',null)->where('o',null));
    }
}

