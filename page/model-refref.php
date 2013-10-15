<?php

class page_modelrefref extends Page_Tester {
    public $db;
    function init(){
        $this->db=$this->add('DB');

        try {
        $this->db->query('drop table user');
        }catch(PDOException $e){}try{
        $this->db->query('drop table item');
        }catch(PDOException $e){}try{
        $this->db->query('drop table purchase');
        }catch(PDOException $e){}
        $this->db->query('create table user (id int not null primary key auto_increment, email varchar(255)');
        $this->db->query('create table item (id int not null primary key auto_increment, price int)');
        $this->db->query('create table purchase (id int not null primary key auto_increment, user_id int, item_id int, `date` datetime)');

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

class Model_User extends Model_Table {
    public $table='user';
    function init(){
        parent::init();

        $this->add('filestore/Field_Image','picture_id');

        $this->addExpression('thumb_url')->set(function($m,$s){
            return $m->refSQL('picture_id/thumb_file_id')->fieldQuery('url');
        });

        // user (filestore thumb join image join filstore original_file) as thumb


        $this->hasMany('Purchase');

        $this->addField('email');

        $this->addExpression('total_purchase')->set(function($m,$s){
            return $m->refSQL('Purchase/item_id')->sum('price');



            $x = $m->ref('item_id/item_details_id');

            // select * from item join purchase on purchase.item_id=item.id 
            // where purchase.user_id in ( select * from complex_model join ... where intermeditae_field = user.id )
        });
    }
}



class Model_Purchase extends Model_Table {
    public $table='purchase';
    function init(){
        parent::init();

        $this->hasOne('User');
        $this->hasOne('Item');

        $this->addField('date')->type('date');
    }
}



class Model_Item extends Model_Table {
    public $table='item';
    function init(){
        parent::init();

        $this->hasMany('Purchase');

        $this->addField('price');
    }
}

/*
class Model_ItemPurchase extends Model_Item {
    function init(){
        parent::init();

        $p=$this->join('purchase');
        $p->addField('date');
        $p->hasOne('Item');
    }

}

*/