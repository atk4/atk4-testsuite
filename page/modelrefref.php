<?php

class page_modelrefref extends Page_Tester {
    public $db;
    function init(){
        $this->db=$this->add('DB');

        try {
        $this->db->query('drop table user_m');
        }catch(PDOException $e){}try{
        $this->db->query('drop table item');
        }catch(PDOException $e){}try{
        $this->db->query('drop table purchase');
        }catch(PDOException $e){}



        $this->db->query('create table user_m (id int not null primary key auto_increment, email varchar(255))');
        $this->db->query('create table item (id int not null primary key auto_increment, name varchar(255), price int)');
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
        $this->a=$this->add('Model_User');
        $this->a['email']='john@mail.com';
        $this->a['name']='John Smith';
        $this->a->save();

        $this->aa=$this->add('Model_User');
        $this->aa['email']='john@mail.com';
        $this->aa['name']='John Smith';
        $this->aa->save();
        
        $this->p=$this->add('Model_Purchase');
        $this->i=$this->add('Model_Item');
        $n=array('Anne','Jane','Aileen','John','Peter','Gavin','David','Marin','Skuja');
        $s=array('Smith','Blogs','Coder','Tester','Hacker');

        for($x=0;$x<100;$x++){
            $this->i['name']=$this->r($n);
            $this->i['price']=1;//rand(50,100);
            $this->i->saveAndUnload();
        }

        for($x=0;$x<50;$x++){
            $this->i->loadRandom()->purchaseBy($this->a);
        }

/*
        for($x=0;$x<2;$x++){
            $this->i->loadRandom()->purchaseBy($this->aa);
        }

*/


        // must have 70 purchases here of random items
        return $this->p->count()->getOne();
    }
    function test_item_cost(){
        return $this->i->sum("price")->getOne();
    }
    function test_all_items(){
        return $this->i->dsql()->del('fields')->field('sum(price)')
            ->join('purchase.item_id')
            ->getOne();
    }
    function test_purchases_1(){
        return $this->i->dsql()->del('fields')->field('sum(price)')
            ->join('purchase.item_id')
            ->where('purchase.user_id',$this->a->id)
            ->debug()
            ->getOne();
    }
    function test_purchases_2(){
        return $this->i->dsql()->del('fields')->field('sum(price)')
            ->join('purchase.item_id')
            ->where('purchase.user_id',$this->aa->id)
            ->debug()
            ->getOne();
    }

}

class Model_User extends Model_Table {
    public $table='user_m';
    function init(){
        parent::init();

        //$this->add('filestore/Field_Image','picture_id');

/*
        $this->addExpression('thumb_url')->set(function($m,$s){
            return $m->refSQL('picture_id/thumb_file_id')->fieldQuery('url');
        });
        */

        // user (filestore thumb join image join filstore original_file) as thumb


        $this->hasMany('Purchase');

        $this->hasMany('ItemPurchase');

        $this->addField('email');

        /*
        $this->addExpression('total_purchase')->set(function($m,$s){
            return $m->refSQL('Purchase/item_id')->sum('price');



            $x = $m->ref('item_id/item_details_id');

            // select * from item join purchase on purchase.item_id=item.id 
            // where purchase.user_id in ( select * from complex_model join ... where intermeditae_field = user.id )
        });
        */
    }
}



class Model_Purchase extends Model_Table {
    public $table='purchase';
    function init(){
        parent::init();

        $this->hasOne('User','user_id');
        $this->hasOne('Item');

        $this->addField('date')->type('date');
    }
}



class Model_Item extends Model_Table {
    public $table='item';
    function init(){
        parent::init();

        $this->hasMany('Purchase');

        $this->addField('name');
        $this->addField('price');
    }

    function purchaseBy(Model_User $u){

        $p=$this->ref('Purchase');
        $p['user_id']=$u['id'];
        $p->save();
        return $this;
    }
}

class Model_ItemPurchase extends Model_Item {
    function init(){
        parent::init();

        $p=$this->join('purchase');
        $p->addField('date');
        $p->hasOne('Item');
    }
}

