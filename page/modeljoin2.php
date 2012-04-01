<?php

class page_modeljoin2 extends Page_DBTest {
    public $db;
    function init(){
        $this->db=$this->add('DB');

        try {
        $this->db->query('drop temporary table author');
        }catch(PDOException $e){}try{
        $this->db->query('drop temporary table book');
        }catch(PDOException $e){}try{
        $this->db->query('drop temporary table contact');
        }catch(PDOException $e){}
        $this->db->query('create temporary table author (id int not null primary key auto_increment, name varchar(255), email varchar(255))');
        $this->db->query('create temporary table book (id int not null primary key auto_increment, name varchar(255), isbn varchar(255), author_id int)');

        $this->db->query('create temporary table contact (id int not null primary key auto_increment, address varchar(255), author_id int)');


        parent::init();
    }
    function prepare(){
        //$this->mb=$this->add('Model_BookAuthor');
        //return array($this->mb->_dsql());
    }
    function test_parentjoin(){
        $m=$this->add('Model_Category');
        $m->hasOne('Category','parent_id');     // alliases must be unique.

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
}

class Model_Author extends Model_Table {
    public $table='author';
    public $table_alias='a';
    function init(){
        parent::init();

        $this->addField('name');
        $this->addField('email');

        //$this->hasMany('Book');
    }
}

class Model_AuthorBook extends Model_Author {
    public $b;
    function init(){
        parent::init();

        $this->b=$this->join('book.author_id',null,'inner','mybook');

        $this->b->addField('isbn');


    }
}
