<?php

class page_model1 extends Page_Tester {
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
        "Test_rewinding"=>'0 100',
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

        $this->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');


        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));

        parent::init();
    }
    function prepare(){
        //return array($this->add('Model_Author'), $this->add('Model_Book'), $this->add('Model_Contact'));
    }
    function r($ar){
        return $ar[rand(0,count($ar))];
    }
    function test_populate(){
        $this->a=$a=$this->add('Model_Author');
        
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<100;$x++){
            $a['name']=$this->r($n).' '.$this->r($s);
            $a->saveAndUnload();
        }


        return $a->count()->getOne();
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
        $a=$this->a=$this->add('Model_Author');

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
    function test_rewinding(){
        $tmp=0;
        $this->a->load(20);
        foreach($this->a as $junk){
            $tmp++;
        }
        $t=$tmp;
        foreach($this->a as $junk){
            $tmp--;
        }
        return $tmp.' '.$t;
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

class Model_Book extends Model_Table {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');

        $this->hasOne('Author');
    }
}
class Model_Author extends Model_Table {
    public $table='author';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('email');

        $this->hasMany('Book');
        $this->hasOne('Contact','my_contact');
    }
}
class Model_Contact extends Model_Table {
    public $table='contact';
    function init(){
        parent::init();

        $this->addField('address');

        $this->hasMany('Author','my_contact');
        /*
         * offers a minor speedup
        $this->addHook('afterInsert',function($m,$id){
            $m->id=$id;
            $m->breakHook(false);
        });
         */
    }
}
