<?php

class page_modeljoin2 extends Page_DBTest {
    function init(){
        $this->db=$this->add('DB');

        try {
            $this->db->query('drop table author');
        }catch(PDOException $e){}try{
            $this->db->query('drop table book');
        }catch(PDOException $e){}try{
            $this->db->query('drop table contact');
        }catch(PDOException $e){}
            $this->db->query('create table author (id int not null primary key auto_increment, name varchar(255), email varchar(255), birth date)');
        $this->db->query('create table book (id int not null primary key auto_increment, name varchar(255), isbn varchar(255), pages int, author_id int)');

        $this->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');


        parent::init();
    }
    function prepare(){
        $this->mb=$this->add('Model_BookAuthor2');
        return array($this->mb->_dsql());
    }
    /*
    function test_j1(){
        $m=$this->add('Model_BookAuthor2');
        return $m->dsql();
    }
    function test_j2(){
        $m=$this->add('Model_BookAuthor2');
        $m->join('book_info','book_info_id');
        return $m->dsql();
    }
    function test_j3(){
        $m=$this->add('Model_BookAuthor2');
        $m->set('name','John');
        $m->set('email','j@mail.com');
        $m->save();

        $m->set('name','Peter');
        $m['isbn']=123123;
        $m->save();

        return $m['name'];
    }
    function test_j4(){
        $m=$this->add('Model_AuthorBook2');
        $m->set('name','John');
        $m->set('email','j@mail.com');
        $m->save();

        $m->set('name','Peter');
        $m['isbn']=123123;
        $m->save();

        return $m->dsql();
    }
    function test_j5(){
        $m=$this->add('Model_BookAuthorContact2');
        $m->set('name','John');
        $m->set('email','j@mail.com');
        $m->save();

        $m->set('name','Peter');
        $m['isbn']=123123;
        $m['address']='IL7';
        $m->save();

        return $m->dsql();
    }
    function test_j6(){
        $m=$this->add('Model_BookAuthorContact2');
        $m->addCondition('name','Peter');
        $m->addCondition('email','j@mail.com');
        $m->addCondition('isbn','123123');
        $m->loadAny();
        $m['address']='IL9';
        $m['pages']=123;
        $m['birth']='2001-02-03';
        $m->save();
        return join(', ',$m->get());
    }
    function test_j7(){
        $m=$this->add('Model_BookAuthorContact2');
        foreach($m as $junk){
            $m['address']='IL10';
            $m['pages']=444;
            $m['birth']='2002-02-03';
            $m->save();
        }
        $m->loadAny();
        return join(', ',$m->get());
    }
    function test_ref($q){
        try{
            $m1=$this->add('Model_Author2')->loadBy('email','j@mail.com');
            return count($m1->ref('Book'));
        }catch(Exception $e){
            $this->api->caughtException( $e);
        }
    }
     */


}

class Model_Book2 extends Model_Table {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');
        $this->addField('pages')->type('int');

        $this->hasOne('Author2');
    }
}
class Model_Author2 extends Model_Table {
    public $table='author';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('email');

        $this->hasMany('Book2');
    }
}
class Model_Contact2 extends Model_Table {
    public $table='contact';
    function init(){
        parent::init();

        $this->addField('address');

        $this->hasMany('Author2');
    }
}

class Model_BookAuthor2 extends Model_Book2 {
    public $a;
    function init(){
        parent::init();
        $this->a=$this->joinModel('Author2');
    }
}

class Model_AuthorBook2 extends Model_Author2 {
    public $b;
    function init(){
        parent::init();

        $this->b=$this->joinModel('Book2');
    }
}

class Model_BookAuthorContact2 extends Model_BookAuthor2 {
    function init(){
        parent::init();

        $this->a->joinModel('Contact2');
    }
}


