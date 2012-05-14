<?php

class page_modeljoin extends Page_DBTest {
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
            0 => 'select  `a`.`id`,`a`.`name`,`a`.`email`,`bbx`.`isbn`,`bbx`.`author_id` `bbx` from `author` `a` inner join `book` as `bbx` on `bbx`.`author_id` = `a`.`id`     ',
            1 => 
            array (
            ),
        ),
        "Test_j5"=>array (
            0 => 'select  `book`.`id`,`book`.`name`,`book`.`isbn`,`book`.`pages`,`book`.`author_id`,(select  `a`.`name` from `author` `a`  where `book`.`author_id` = `a`.`id`    ) `author`,`_a`.`email`,`_a`.`birth`,`_c`.`address`,`book`.`author_id` `_a`,`_c`.`author_id` `_c` from `book` inner join `author` as `_a` on `_a`.`id` = `book`.`author_id` inner join `contact` as `_c` on `_c`.`author_id` = `_a`.`id`     ',
            1 => 
            array (
            ),
        ),
        "Test_j6"=>array (
            0 => '3, Peter, 123123, 123, 3, , j@mail.com, 2001-02-03, IL9',
            1 => 
            array (
            ),
        ),
        "Test_j7"=>array (
            0 => '3, Peter, 123123, 444, 3, , j@mail.com, 2002-02-03, IL10',
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
            $this->db->query('create table author (id int not null primary key auto_increment, name varchar(255), email varchar(255), birth date)');
        $this->db->query('create table book (id int not null primary key auto_increment, name varchar(255), isbn varchar(255), pages int, author_id int)');

        $this->db->query('create table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');


        parent::init();
    }
    function prepare(){
        $this->mb=$this->add('Model_BookAuthor');
        return array($this->mb->_dsql());
    }
    function test_j1(){
        $m=$this->add('Model_BookAuthor');
        return $m->dsql();
    }
    function test_j2(){
        $m=$this->add('Model_BookAuthor');
        $m->join('book_info','book_info_id');
        return $m->dsql();
    }
    function test_j3(){
        $m=$this->add('Model_BookAuthor');
        $m->set('name','John');
        $m->set('email','j@mail.com');
        $m->save();

        $m->set('name','Peter');
        $m['isbn']=123123;
        $m->save();

        return $m['name'];
    }
    function test_j4(){
        $m=$this->add('Model_AuthorBook');
        $m->set('name','John');
        $m->set('email','j@mail.com');
        $m->save();

        $m->set('name','Peter');
        $m['isbn']=123123;
        $m->save();

        return $m->dsql();
    }
    function test_j5(){
        $m=$this->add('Model_BookAuthorContact');
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
        $m=$this->add('Model_BookAuthorContact');
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
        $m=$this->add('Model_BookAuthorContact');
        $m->debug();
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
            $m1=$this->add('Model_Author')->loadBy('email','j@mail.com');
            return count($m1->ref('Book'));
        }catch(Exception $e){
            $this->api->caughtException( $e);
        }
    }


}

class Model_Book extends Model_Table {
    public $table='book';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('isbn');
        $this->addField('pages')->type('int');

        $this->hasOne('Author');
    }
}
class Model_Author extends Model_Table {
    public $table='author';
    public $table_alias='a';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('email');

        $this->hasMany('Book');
    }
}

class Model_BookAuthor extends Model_Book {
    public $a;
    function init(){
        parent::init();
        $this->a=$this->join('author');
        $this->a->addField('email');
        $this->a->addField('birth')->type('date');
    }
}

class Model_AuthorBook extends Model_Author {
    public $b;
    function init(){
        parent::init();

        $this->b=$this->join('book.author_id',null,'inner','bbx');

        $this->b->addField('isbn');


    }
}

class Model_BookAuthorContact extends Model_BookAuthor {
    function init(){
        parent::init();

        $this->c=$this->a->join('contact.author_id');
        $this->c->addField('address');
    }
}

