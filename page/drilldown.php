<?php
class page_drilldown extends Page {
    function init(){
        parent::init();
        $this->populate();

        $m=$this->add('Model_Category');

        $m->deleteAll();
        $m['name']='US';
        $m->saveAndUnload();
        $m['name']='Europe';
        $m=$m->save()->ref('Category');

        $m['name']='Italy';
        $m->saveAndUnload();
        $m['name']='UK';
        $m=$m->save()->ref('Category');

        $m['name']='London';
        $m->save();

        $this->add('H4')->set('Contents of Categories');
        $this->add('Grid')->setModel('Category');


        $this->add('H4')->set('Manual Field');
        $f=$this->add('Form');
        $f->addField('misc/drilldown','my_field')->setModel('Category');

        $this->add('H4')->set('Automatically Added By MVC');
        $f=$this->add('Form')->setModel('Category')->load($m->id);
    }
    function populate(){
        try {
        $this->api->db->query('drop table category');
        }catch(PDOException $e){}
        $this->api->db->query('create table category (id int not null primary key auto_increment, name varchar(255), parent_id int)');
    }
}

class Model_Category extends Model_Table {
    public $table='category';
    function init(){
        parent::init();
        $this->hasOne('Category','parent_id')->display(array('form'=>'misc/drilldown'));
        $this->hasMany('Category','parent_id');

        $this->addField('name');
    }
}
