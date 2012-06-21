<?php
class Model_Author53 extends Model_Table {

    public $table='author';

    function init(){
        parent::init();
        $this->addField('long_name');
        $this->addField('DOB');

    }
}

class Model_Book53 extends Model_Table {

    public $table='book';

    function init(){
        parent::init();

        $this->addField('title');
        $this->hasOne('Author53', 'author_id', 'long_name');
    }

}

class page_issue_53 extends Page {

    function init() {
        parent::init();


        $this->db=$this->add('DB');

        try {
            $this->db->query('drop table author');
        }catch(PDOException $e){}try{
            $this->db->query('drop table book');
        }catch(PDOException $e){
        }
        $this->db->query('create table author (id int not null primary key auto_increment, long_name varchar(255), DOB date)');
        $this->db->query('create table book (id int not null primary key auto_increment, title varchar(255), isbn varchar(255), pages int, author_id int)');

        $m=$this->add('Model_Author53');
        $m['long_name']='John Smith';$m->saveAndUnload();
        $m['long_name']='Joe Blogs';$m->saveAndUnload();

        $m=$this->add('Model_Book53');
        $m['author_id']=1;
        $m['title']='John\'s Book';
        $m->save();

        $this->add('CRUD')->setModel('Book53');
    } 
}
