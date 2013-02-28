<?php

class page_model1 extends Page_Tester {
    public $author_class='Model_Author';
    public $db;
    public $proper_responses=array(
            "Test_populate"=>'100',
            "Test_refmode_default"=>'1',
            "Test_refmode_create"=>'1',
            "Test_refmode_create2"=>'2',
            "Test_refmode_create3"=>'3',
            "Test_refmode_create4"=>'3',
            "Test_refmode_link"=>'LOAD 45//-<br/>REF 45//<br/>SAVE 45/4/4<br/>RELOAD 45/4/-',
            "Test_refmode_ignore"=>'45/4/',
            "Test_refmode_load"=>'OK',
            "Test_refmode_default2"=>'4',
            "Test_populate2"=>'100',
            "Test_clones"=>'0',
            "Test_loadbyExpr"=>'Exception: BaseException: No matching records found (Raised by object=Object Model_Author(sample_project_model1_model_author_2)) in :<p id="sample_project_model1_loadbyExpr" class="" style=""><a id="sample_project_model1_loadbyExpr_view" class="" style="" href="#">More details</a>
</p>
',
            "Test_rewinding"=>'100=100',
            "Test_emptyafteriterate"=>'UNLOADED',
            "Test_multiref"=>'3',
            "Test_many1"=>'3',
            "Test_many2"=>'3'
        );
    function init(){
        $this->db=$this->add('DB');

        try {
        $this->db->query('drop table author');
        }catch(PDOException $e){}try{
        $this->db->query('drop table book');
        }catch(PDOException $e){}try{
        $this->db->query('drop table contact');
        }catch(PDOException $e){}
        $this->db->query('create table author (id int not null primary key auto_increment, name varchar(255), email varchar(255),my_contact int)');
        $this->db->query('create table book (id int not null primary key auto_increment, name varchar(255), isbn varchar(255), author_id int)');

        $this->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), line1 varchar(255), street varchar(255), author_id int)');


        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));

        $this->a=$a=$this->add($this->author_class);
        $this->a->deleteAll();

        $a=$this->a;
        if($a->hasMethod('addCache')){
            $c = $a->addCache('Dumper','zz');
            $c->setPrimarySource($a,'Array');
        }
        
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<100;$x++){
            $a['name']=$this->r($n).' '.$this->r($s);
            $a->saveAndUnload();
        }


        parent::init();
    }
    function prepare(){
        //return array($this->add('Model_Author'), $this->add('Model_Book'), $this->add('Model_Contact'));
    }
    function r($ar){
        return $ar[rand(0,count($ar))];
    }
    function test_populate(){


        return $this->a->count()->getOne();
    }
    function test_refmode_default(){
        return !$this->a->load(41)->ref('my_contact')->loaded();
    }
    function test_refmode_create(){
        return $this->a->load(42)->ref('my_contact','create')->id;
    }
    function test_refmode_create2(){
        return $this->a->load(43)->ref('my_contact','create')->id;
    }
    function test_refmode_create3(){
        $this->a->load(44)->ref('my_contact','create');
        return $this->a->get('my_contact');
    }
    function test_refmode_create4(){
        return $this->a->load(44)->get('my_contact');
    }
    function test_refmode_link(){
        $this->a->load(45);
        $s='';
        $s.='LOAD '.$this->a->id.'/'.$this->a['my_contact']."/-<br/>";
        $r=$this->a->ref('my_contact','link');
        $s.='REF '.$this->a->id.'/'.$this->a['my_contact'].'/'.$r->id.'<br/>';
        $r->set('address','xx')->save();
        $s.='SAVE '.$this->a->id.'/'.$this->a['my_contact'].'/'.$r->id.'<br/>';

        $this->a->load(45);
        $s.='RELOAD '.$this->a->id.'/'.$this->a['my_contact']."/-";

        return $s;
    }
    function test_refmode_ignore(){
        $this->a->load(45);
        $r=$this->a->ref('my_contact',false);
        return $this->a->id.'/'.$this->a['my_contact'].'/'.$r->id;
    }
    function test_refmode_load(){
        $this->a->load(46);
        try{
        $r=$this->a->ref('my_contact','load');
        }catch(BaseException $e){
            return 'OK';
        } 
        return 'bad';
    }
    function test_refmode_default2(){
        return $this->a->load(45)->ref('my_contact')->id;
    }
    function test_populate2(){
        $a=$this->a=$this->add($this->author_class);

        foreach($a as $junk){
            $id=$a->ref('my_contact')->set('address',rand(1,1000))->save()->id;
            $a->set('my_contact', $id)->saveAndUnload();
        }

        $c=$this->add('Model_Contact');

        return $c->count()->getOne();
    }
    function test_clones(){

        $a=clone $this->a;
        $a->loadBy('my_contact',30);
        $a['email']='test@example.org';
        $a->save();

        $a->loadBy('my_contact',33);
        $a['email']='test@example.org';
        $a->save();

        $a=clone $this->a;
        $a->addCondition('email','test@example.org');
        return $a->count()->getOne();
    }
    function test_loadbyExpr(){
        $a = clone $this->a;
        $a->loadBy($a->dsql()->andExpr()->where('my_contact',33)->where('email','test@example.org'));
        return $a->loaded();
    }
    function test_rewinding(){
        $t1=$t2=0;
        //$this->a->load(20);
        foreach($this->a as $junk){
            $t1++;
        }
        foreach($this->a as $junk){
            $t2++;
        }
        return $t1.'='.$t2;
    }
    function test_emptyafteriterate(){
        $t1=0;
        foreach($this->a as $junk){
            $t1++;
        }
        return $this->a->loaded()?'LOADED':'UNLOADED';
    }
    function test_multiref(){
        $this->a->load(20)->ref('Book')->set('name','book1')->save();
        $this->a->load(20)->ref('Book')->set('name','book2')->save();
        $this->a->load(23)->ref('Book')->set('name','book3')->save();
        return $this->add('Model_Book')->count()->getOne();
    }
    function test_many1(){
        $cnt=0;

        foreach($this->a as $junk){
            $cnt+=$this->a->ref('Book')->count()->getOne();
        }

        return $cnt;

    }
    function test_many2(){
        $cnt=0;

        foreach($this->a as $junk){
            $cnt+=$this->a->ref('Book')->count()->getOne();
        }

        return $cnt;

    }


}
