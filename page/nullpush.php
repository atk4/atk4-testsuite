<?php

/*
 More info: https://groups.google.com/forum/#!topic/agile-toolkit-devel/sE3dkCMPznk
 */

class Model_Demo extends Model_Table {
  public $table='demo';
  function init() {
    parent::init();
    $this->addField('sometext');
  }
}

class page_nullpush extends Page_DBTest {
    public $proper_responses=array(
        "Test_simple"=>array (
  0 => '1',
  1 => 
  array (
  ),
)
    );
    function tableInit(){
        if($this->db->type=='mysql'){
            $this->db->query('drop table if exists demo');
            $this->db->query("create table `demo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sometext` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)");
        }elseif($this->db->type=='sqlite'){

        }
        
    }
    function test_simple(){
        $demo=$this->add('Model_Demo');
        $demo->tryLoadAny();
        $demo->save();

        return $demo->id;
    }
}

