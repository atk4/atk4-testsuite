<?php

class page_model1 extends Page_Tester {
    public $db;
        public $proper_responses=array(
        "Test_j1"=>array (
  0 => 'select  *,`book`.`id` from `book` inner join `author` as `_a` on `_a`.`id` = `book`.`author_id`     ',
  1 => 
  array (
  ),
),
        "Test_j2"=>array (
  0 => 'select  *,`book`.`id` from `book` inner join `author` as `_a` on `_a`.`id` = `book`.`author_id` inner join `book_info` as `_b` on `_b`.`id` = `book`.`book_info_id`     ',
  1 => 
  array (
  ),
),
        "Test_j3"=>array (
  0 => 'Peter',
  1 => 
  array (
  ),
),
        "Test_j4"=>array (
  0 => 'select  `a`.`id`,`a`.`name`,`a`.`email`,`bbx`.`isbn`,`bbx`.`author_id` `bbx`,`bbx`.`author_id` `bbx` from `author` `a` inner join `book` as `bbx` on `bbx`.`author_id` = `a`.`id`     limit 0, 1',
  1 => 
  array (
  ),
),
        "Test_j5"=>array (
  0 => 'select  `book`.`id`,`book`.`name`,`book`.`isbn`,`book`.`author_id`,(select  `a`.`name` from `author` `a`  where `book`.`author_id` = `a`.`id`    ) `author`,`_a`.`email`,`_c`.`address`,`book`.`author_id` `_a`,`_c`.`author_id` `_c`,`book`.`author_id` `_a`,`_c`.`author_id` `_c` from `book` inner join `author` as `_a` on `_a`.`id` = `book`.`author_id` inner join `contact` as `_c` on `_c`.`author_id` = `_a`.`id`     limit 0, 1',
  1 => 
  array (
  ),
),
        "Test_ref"=>array (
  0 => '1',
  1 => 
  array (
  ),
)
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
        $a=$this->add('Model_Author');
        
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<100;$x++){
            $a['name']=$this->r($n).' '.$this->r($s);
            $a->saveAndUnload();
        }


        return $a->count()->getOne();
    }
    function test_populate2(){
        $a=$this->a=$this->add('Model_Author');

        foreach($a as $junk){
            $id=$a->ref('my_contact',false)->set('address',rand(1,1000))->save()->id;
            $a->set('my_contact', $id)->saveAndUnload();
        }

        $c=$this->add('Model_Contact');

        return $c->count()->getOne();
    }
    function test_populate3(){

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


        return;
        $a=$this->add('Model_Author');
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<1;$x++){
            $a['name']=$this->r($n).' '.$this->r($s);
            $a->saveAndUnload();
        }


        return $a->count()->getOne();
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
