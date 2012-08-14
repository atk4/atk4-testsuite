<?php

class page_model2 extends Page_Tester {
    public $db;
        public $proper_responses=array(
        "Test_boolean"=>'0',
        "Test_boolean2"=>'1',
        "Test_booleanenum"=>'n',
        "Test_booleanenum1"=>'y',
        "Test_booleanenum2"=>'',
        "Test_booleanenum4"=>'1'
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
        $this->db->query('create table book (id int not null primary key auto_increment, deleted char(1), name varchar(255), isbn varchar(255), author_id int)');

        $this->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');


        $this->api->pathfinder->addLocation('..',array('addons'=>'atk4-addons'));

        parent::init();
    }
    function prepare(){
        //return array($this->add('Model_Author'), $this->add('Model_Book'), $this->add('Model_Contact'));
    }
    function test_boolean(){
        $m=$this->add('Model_Book');
        $m['name']='hello';
        $m->save();
        return $m['deleted'];
    }
    function test_boolean2(){
        $m=$this->add('Model_Book');
        $m['name']='hello';
        $m['deleted']=true;
        $m->save();
        return $m['deleted'];
    }
    function test_booleanenum(){
        $m=$this->add('Model_Book');
        $m->getField('deleted')->enum(array('y','n'));
        $m['name']='hello';
        $m->save();
        return $m['deleted'];
    }
    function test_booleanenum1(){
        $m=$this->add('Model_Book');
        $m->getField('deleted')->enum(array('y','n'));
        $m['name']='hello';
        $m['deleted']=true;
        $m->save();
        return $m['deleted'];
    }
    function test_booleanenum2(){
        $m=$this->add('Model_Book');
        $m->getField('deleted')->enum(array('y'));
        $m['name']='hello';
        $m->save();
        return $m['deleted'];
    }
    function test_booleanenum4(){
        $m=$this->add('Model_Book');
        $m->addCondition('deleted',true);
        $m['name']='hello';
        $m->save();
        return $m['deleted'];
    }
    function test_doubleand(){
        $m=$this->add('Model_Book');
        $m->addCondition('isbn','>=','a');
        $m->addCondition('isbn','<=','a');
        $m->debug();
        $m->tryLoadAny();
        return $m->loaded()?'inclusive':'exclusive';
    }
    function test_doubleandexpr(){
        $m=$this->add('Model_Book');
        $m->addExpression('age')->set('123');
        $m->addCondition('age','>=',5);
        $m->addCondition('age','<=',5);
        $m->debug();
        $m->tryLoadAny();
        return $m->loaded()?'inclusive':'exclusive';
    }


}

class Model_Book extends Model_Table {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');

        $this->newField('deleted')
            ->datatype('boolean')
            ->defaultValue(false);

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
