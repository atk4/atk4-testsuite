<?php
class Page_UITest extends Page {

    function populateData(){
        try{
            $a=$this->add('Model_Author');
            $a->tryLoadAny();
            if($a->loaded()){
                if(strtotime($a['created'])>strtotime('10 minutes ago'))return;
            }
            $this->js(true)->univ()->successMessage('Test data is too old, regenerating');
        }catch(Exception $e){
            $this->js(true)->univ()->successMessage('Test data does not exist, regenerating');
        }


        try {
        $this->api->db->query('drop table author');
        }catch(PDOException $e){}try{
        $this->api->db->query('drop table book');
        }catch(PDOException $e){}try{
        $this->api->db->query('drop table contact');
        }catch(PDOException $e){}
        $this->api->db->query('create table author (id int not null primary key auto_increment, name varchar(255), email varchar(255),my_contact int,created datetime)');
        $this->api->db->query('create table book (id int not null primary key auto_increment, name varchar(255), isbn varchar(255), author_id int)');
        $this->api->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');
        //$this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));


        $this->a=$a=$this->add('Model_Author');
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<100;$x++){
            $a['name']=$this->r($n).' '.$this->r($s);
            $a->saveAndUnload();
        }

        $a=$this->a=$this->add('Model_Author');

        foreach($a as $junk){
            $id=$a->ref('my_contact')->set('address',rand(1,1000))->save()->id;
            $a->set('my_contact', $id)->saveAndUnload();
        }


    }
    function r($ar){
        return $ar[rand(0,count($ar))];
    }
    function init(){
        parent::init();
        $this->api->dbConnect();
        $this->populateData();


        parent::init();



        $test_obj=$this;
        foreach(get_class_methods($test_obj) as $method){
            if(substr($method,0,5)=='test_'){
                $m=substr($method,5);
            }else continue;

            $this->test_headers[$m]=$this->add('H3')->set('Test: '.ucwords(str_replace('_',' ',$m)));

            $result=(string)$test_obj->$method();


        }


        $me=memory_get_peak_usage();
        $ms=microtime(true);

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
        $this->addField('created')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));


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
    }
}
