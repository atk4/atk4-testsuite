<?php

class page_dbwhere2 extends Page_DBTest {
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
    function test_where_or5($t){
        return $t->SQLTemplate('update')->set('name',$t->dsql()->table('bar')->field('name')->where('id',$t->getField('id')));
    }
}
