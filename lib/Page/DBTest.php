<?php
class Page_DBTest extends Page_Tester {
    function init(){
        $this->dbconn=$this->api->recall('dbconn','mysql');


        // Driver switching logic
        $ff=$this->add('Form');
        $ff->addField('dropdown','dbc','DB Connection')
            ->setValueList(array('mysql'=>'Default','sqlite'=>'SQLite'))
            ->set($this->dbconn)
            ->js('change',$ff->js()->submit());
        if($ff->isSubmitted()){
            $this->api->memorize('dbconn',$ff->get('dbc'));
            $this->js()->univ()->redirect($this->api->url())->execute();
        }



        try{
            $this->db=$this->add('DB')->connect($this->dbconn);
        }catch(Exception $e){
            $this->add('View_Error')->set($e->getMessage());
            Page::init();
            return;
        }


        if($this->db->type=='mysql'){
            $this->db->query('drop temporary table if exists foo');
            $this->db->query('create temporary table if not exists foo (id int not null primary key auto_increment, name varchar(255), a int, b
                int, c int)');
        }elseif($this->db->type=='sqlite'){
            $this->db->query('drop table if exists foo');
            $this->db->query('create table if not exists foo (id integer primary key, name varchar(255), a int, b
                int, c int)');
        }








        parent::init();
    }
    function runTests(){
        $this->grid->addColumn('text','Test_para');
        return parent::runTests();
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
}
