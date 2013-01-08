<?php

class page_db extends Page_DBTest {
    public $db;
    public $proper_responses=array(
            "Test_raw_insert"=>array (
  0 => '',
  1 => 
  array (
  ),
),
            "Test_raw_params"=>array (
  0 => '1',
  1 => 
  array (
  ),
),
            "Test_raw_getOne"=>array (
  0 => 'John',
  1 => 
  array (
  ),
),
            "Test_raw_select"=>array (
  0 => 'John, Peter, Ian, Steve, Robert, Lucas, Jane, Dot, Param',
  1 => 
  array (
  ),
),
            "Test_simple"=>array (
  0 => 'select  `foo` from `bar`      ',
  1 => 
  array (
  ),
),
            "Test_simple_tostring"=>array (
  0 => 'select  `foo` from `bar`      ',
  1 => 
  array (
  ),
),
            "Test_simple_dot"=>array (
  0 => 'select  `x`.foo.bar from `bar`      ',
  1 => 
  array (
  ),
),
            "Test_multifields"=>array (
  0 => 'select  `a`,`b`,`c` from `bar`      ',
  1 => 
  array (
  ),
),
            "Test_multitable"=>array (
  0 => 'select  `foo`.`a`,`foo`.`b`,`foo`.`c`,`bar`.`x`,`bar`.`y` from `bar`,`baz`      ',
  1 => 
  array (
  ),
),
            "Test_selectall"=>array (
  0 => 'select  * from `bar`      ',
  1 => 
  array (
  ),
),
            "Test_select_opton1"=>array (
  0 => 'select SQL_CALC_FOUND_ROWS * from `foo`      ',
  1 => 
  array (
  ),
),
            "Test_select_calc_rows"=>array (
  0 => 'select SQL_CALC_FOUND_ROWS * from `foo`      limit 0, 5',
  1 => 
  array (
  ),
),
            "Test_select_calc_rows2"=>array (
  0 => '9',
  1 => 
  array (
  ),
),
            "Test_select_calc_rows3"=>array (
  0 => '1',
  1 => 
  array (
  ),
),
            "Test_row"=>array (
  0 => '{"id":"2","name":"Peter","a":"2","b":"4","c":"7"}',
  1 => 
  array (
    ':a' => 2,
  ),
),
            "Test_getAll"=>array (
  0 => '[{"id":"1","name":"John","a":"1","b":"2","c":"3"},{"id":"2","name":"Peter","a":"2","b":"4","c":"7"}]',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_iter1"=>array (
  0 => '1,John,1,2,3',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_iter2"=>array (
  0 => '1,2',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_doubleget"=>array (
  0 => '1',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_doubleiter"=>array (
  0 => '1',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_iteriter"=>array (
  0 => '9=9',
  1 => 
  array (
  ),
),
            "Test_ts"=>array (
  0 => 'select  * from `foo`      ',
  1 => 
  array (
  ),
),
            "Test_expr"=>array (
  0 => 'call foobar()',
  1 => 
  array (
  ),
),
            "Test_expr1"=>array (
  0 => '(select 1)',
  1 => 
  array (
  ),
),
            "Test_expr2"=>array (
  0 => 'select  (select 1) `x1`,3+3 `x2`        ',
  1 => 
  array (
  ),
),
            "Test_expr3"=>array (
  0 => 'acceptance',
  1 => 
  array (
  ),
),
            "Test_expr4"=>array (
  0 => 'foo',
  1 => 
  array (
  ),
),
            "Test_expr5"=>array (
  0 => 'foo..bar',
  1 => 
  array (
  ),
),
            "Test_update"=>array (
  0 => 'update `foo` set `name`=:a where `id` = :a_2',
  1 => 
  array (
    ':a' => 'Silvia',
    ':a_2' => '1',
  ),
),
            "Test_update2"=>array (
  0 => '[{"id":"1","name":"Silvia","a":"1","b":"2","c":"3"},{"id":"2","name":"Peter","a":"2","b":"4","c":"7"}]',
  1 => 
  array (
    ':a' => 1,
    ':a_2' => 2,
  ),
),
            "Test_update_then_select"=>array (
  0 => 'select  * from `foo`  where `id` = :a    ',
  1 => 
  array (
    ':a' => 1,
  ),
),
            "Test_insert_all"=>array (
  0 => '10,11',
  1 => 
  array (
    ':a' => 'O\'Brien X',
    ':a_2' => 2,
    ':a_3' => 9,
  ),
)
        );

    function test_raw_insert($t){
        $this->db->query('insert into foo (name,a,b,c) values ("John", 1,2,3)');
        $this->db->query('insert into foo (name,a,b,c) values ("Peter", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Ian", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Steve", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Robert", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Lucas", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Jane", 2,4,7)');
        $this->db->query('insert into foo (name,a,b,c) values ("Dot", 2,4,7)');
    }
    function test_raw_params($t){
        $this->db->query('insert into foo (name,a,b,c) values (:1, :2,:3, :4)',
            array(':1'=>'Param',':2'=>1,':3'=>2,':4'=>3)
        );
        return $this->db->getOne('select count(*) from foo where name=:1',array(':1'=>'Param'));
    }
    function test_raw_getOne($t){
        return $this->db->getOne('select name from foo');
    }
    function test_raw_select($t){
        $stmt=$this->db->query('select name from foo');
        $data=array();
        foreach($stmt as $row){
            $data[]=$row['name'];
        }
        return implode(', ',$data);
    }
    function test_simple($t){
        return $t->table('bar')->field('foo');
    }
    function test_simple_tostring($t){
        return $t->table('bar')->field('foo');
    }
    function test_simple_dot($t){
        return $t->table('bar')->field('foo.bar','x');
    }
    function test_multifields($t){
        return $t->table('bar')->field(array('a','b','c'));
    }
    function test_multitable($t){
        return $t->table(array('bar','baz'))->field(array('a','b','c'),'foo')->field(array('x','y'),'bar');
    }
    function test_selectall($t){
        return $t->table('bar');
    }
    function test_select_opton1($t){
        return $t->table('foo')->option('SQL_CALC_FOUND_ROWS');
    }
    function test_select_calc_rows($t){
        return $t->table('foo')->limit(5)->calc_found_rows();
    }
    function test_select_calc_rows2($t){
        $data=$t->table('foo')->limit(5)->calc_found_rows();
        return $t->foundRows();
    }
    function test_select_calc_rows3($t){
        $data=$t->table('foo')->limit(5)->get();// not using option, backward-compatible mode
        return $t->foundRows();
    }
    function test_row($t){
        return json_encode($t->table('foo')->where('id',2)->fetch());
    }
    function test_getAll($t){
        return json_encode($t->table('foo')->where('id',array(1,2))->get(),true);
    }
    function test_iter1($t){
        foreach($t->table('foo')->where('id',array(1,2)) as $row){
            return join(',',$row);
        }
        return 'OPS';
    }
    function test_iter2($t){
        $res=array();
        $t->table('foo')->where('id',array(1,2))->each(function($row) use(&$res){
            $res[]=$row['id'];
        });
        return join(',',$res);
    }
    function test_doubleget($t){
        $t->table('foo')->where('id',array(1,2));
        return $t->get()==$t->get();
    }
    function test_doubleiter($t){
        switch(1) {
        case 1:
            foreach($t->table('foo')->where('id',array(1,2)) as $row){
                $r=join(',',$row);
                break;
            }
        }
        foreach($t as $row){
            return $r==join(',',$row);
        }
        return "OPS";
    }
    function test_iteriter($t){
        $t1=$t2=0;
        foreach($t->table('foo') as $row){
            $t1++;
        }
        foreach($t as $row){
            $t2++;
        }
        return "$t1=$t2";
    }
    function test_ts($t){
        return $t->table('foo');
    }
    function test_expr($t){
        return $t->expr('call foobar()');
    }
    function test_expr1($t){
        return $t->expr('(select 1)');
    }
    function test_expr2($t){
        return $t
            ->field($t->expr('(select 1)'),'x1')
            ->field($t->expr('3+3'),'x2');
    }
    function test_expr3($t){
        return $t->expr('show tables')->getOne();
    }
    function test_expr4($t){
        return $t->expr('select [args]')->args(array('foo'))->getOne();
    }
    function test_expr5($t){
        return implode(',',$t->expr('select concat_ws([args])')->args(array('..','foo','bar'))->getHash());
    }
    function test_update($t){
        return $t->table('foo')->where('id','1')->set('name','Silvia')->SQLTemplate('update');
    }
    function test_update2($t){
        $tt=clone $t;
        $tt->table('foo')->where('id','1')->set('name','Silvia')->update();
        return json_encode($t->table('foo')->where('id',array(1,2))->getAll(),true);
    }
    function test_update_then_select($t){
        // executes update then returns select query
        return $t->table('foo')->where('id',1)->set('name','No1')->update();
    }
    function test_insert_all($t){
        return implode(',',$t->table('foo')->insertAll(array(
            array('name'=>'Jane "X-Men"','a'=>'2'),
            array('name'=>'O\'Brien X','b'=>2,'c'=>9),
        )));
    }
}
