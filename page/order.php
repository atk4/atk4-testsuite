<?php
class page_order extends Page_DBTest {
    public $proper_responses=array(
            "Test_order1"=>array (
  0 => 'select  * from `book`     order by `name` ',
  1 => 
  array (
  ),
),
            "Test_order_keyword"=>array (
  0 => 'select  * from `book`     order by `name` desc ',
  1 => 
  array (
  ),
),
            "Test_order_wrong_keyword"=>array (
  0 => 'Exception: Exception_DB: Incorrect ordering keyword (order by=bleh) in /Users/rw/Sites/atk42/atk4/lib/DB/dsql.php:1003<p id="sample_project_order_order_wrong_keyword" class="" style=""><a id="sample_project_order_order_wrong_keyword_view" class="" style="" href="#">More details</a>
</p>
',
  1 => 
  array (
  ),
),
            "Test_order_arg1"=>array (
  0 => 'select  * from `book`     order by `name` desc ',
  1 => 
  array (
  ),
),
            "Test_order_arg2"=>array (
  0 => 'select  * from `book`     order by `name` desc ',
  1 => 
  array (
  ),
),
            "Test_order_arg3"=>array (
  0 => 'select  * from `book`     order by `name` ',
  1 => 
  array (
  ),
),
            "Test_order_commas"=>array (
  0 => 'select  * from `book`     order by `name`, `id` desc, `isbn` ',
  1 => 
  array (
  ),
),
            "Test_order_argcommas"=>array (
  0 => 'Exception: Exception_DB: If first argument is array, second argument must not be used () in /Users/rw/Sites/atk42/atk4/lib/DB/dsql.php:981<p id="sample_project_order_order_argcommas" class="" style=""><a id="sample_project_order_order_argcommas_view" class="" style="" href="#">More details</a>
</p>
',
  1 => 
  array (
  ),
),
            "Test_order_chaining"=>array (
  0 => 'select  * from `book`     order by `isbn` desc, `name` ',
  1 => 
  array (
  ),
),
            "Test_order_dots"=>array (
  0 => 'select  * from `book`     order by `book`.`name` desc, `book`.`isbn` ',
  1 => 
  array (
  ),
),
            "Test_order_dots2"=>array (
  0 => 'select  * from `book`     order by `book`.`name` desc, `book`.`isbn` ',
  1 => 
  array (
  ),
),
            "Test_order_noexpr"=>array (
  0 => 'select  * from `book`     order by now() ',
  1 => 
  array (
  ),
),
            "Test_order_expr"=>array (
  0 => 'select  * from `book`     order by now() ',
  1 => 
  array (
  ),
),
            "Test_order_concat"=>array (
  0 => 'select  * from `book`     order by concat(`book`.`name`, :a, `book`.`isbn`) ',
  1 => 
  array (
    ':a' => ' ',
  ),
),
            "Test_order_field"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name` ',
  1 => 
  array (
  ),
),
            "Test_order_fieldexpr"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by now() ',
  1 => 
  array (
  ),
),
            "Test_order_subquery"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by (select  `name` from `author`  where `author`.`id` = `book`.`author_id`    ) ',
  1 => 
  array (
  ),
),
            "Test_setorder"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name` ',
  1 => 
  array (
  ),
),
            "Test_setorder_nofield"=>array (
  0 => 'Exception: BaseException: Child element not found (Raised by object=Object Model_Book(sample_project_order_model_book_5), element=nosuchfield) in :<p id="sample_project_order_setorder_nofield" class="" style=""><a id="sample_project_order_setorder_nofield_view" class="" style="" href="#">More details</a>
</p>
',
  1 => 
  array (
  ),
),
            "Test_setorder_fielquery"=>array (
  0 => 'select  `name` from `book`     order by `book`.`name` ',
  1 => 
  array (
  ),
),
            "Test_setorder_comma"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name`, `book`.`isbn` ',
  1 => 
  array (
  ),
),
            "Test_setorder_argcomma"=>array (
  0 => 'Exception: BaseException: If first argument is array, second argument must not be used (Raised by object=Object Model_Book(sample_project_order_model_book_8)) in :<p id="sample_project_order_setorder_argcomma" class="" style=""><a id="sample_project_order_setorder_argcomma_view" class="" style="" href="#">More details</a>
</p>
',
  1 => 
  array (
  ),
),
            "Test_setorder_argboolean"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name` desc ',
  1 => 
  array (
  ),
),
            "Test_setorder_argkeyword"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name` desc ',
  1 => 
  array (
  ),
),
            "Test_setorder_commakeyword"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`id` desc, `book`.`isbn`, `book`.`name` ',
  1 => 
  array (
  ),
),
            "Test_setorder_exprfield"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by now() ',
  1 => 
  array (
  ),
),
            "Test_setorder_expr"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by now() ',
  1 => 
  array (
  ),
),
            "Test_setorder_fieldobject"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`name` ',
  1 => 
  array (
  ),
),
            "Test_setorder_chaining"=>array (
  0 => 'select  *,`book`.`id` from `book`     order by `book`.`isbn`, `book`.`name` desc ',
  1 => 
  array (
  ),
)
        );
    function test_order1($t){
        return $t->table('book')->order('name');
    }
    function test_order_keyword($t){
        return $t->table('book')->order('name desc');
    }
    function test_order_wrong_keyword($t){
        return $t->table('book')->order('name bleh');  // error
    }
    function test_order_arg1($t){
        return $t->table('book')->order('name','desc');
    }
    function test_order_arg2($t){
        return $t->table('book')->order('name',true);
    }
    function test_order_arg3($t){
        return $t->table('book')->order('name','asc');
    }
    function test_order_commas($t){
        return $t->table('book')->order('name,id desc,isbn asc');
    }
    function test_order_argcommas($t){
        return $t->table('book')->order('name,id desc,isbn asc',true); // error
    }
    function test_order_chaining($t){
        return $t->table('book')->order('name')->order('isbn','desc');
    }
    function test_order_dots($t){
        return $t->table('book')->order('book.name desc,book.isbn');
    }
    function test_order_dots2($t){
        return $t->table('book')->order('`book`.name desc , book.`isbn`');
    }
    function test_order_noexpr($t){
        return $t->table('book')->order('now()'); // detects bracket, treats as expression
    }
    function test_order_expr($t){
        return $t->table('book')->order($t->expr('now()'));
    }
    function test_order_concat($t){
        return $t->table('book')->order($t->concat($t->getField('name'),' ',$t->getField('isbn')));
    }
    function test_order_field($t){
        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->getElement('name'));
    }
    function test_order_fieldexpr($t){
        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->addExpression('date')->set('now()'));
    }
    function test_order_subquery($t){

        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->refSQL('author_id')->fieldQuery($m->getElement('name')));
           // select * from book order by (select name from author where book.author_id=author.id)
    }
    function test_setorder($t){
        // Model ordering
        return $m=$this->add('Model_Book')->setOrder('name')->dsql();
    }
    function test_setorder_nofield($t){
        return $m=$this->add('Model_Book')->setOrder('nosuchfield')->dsql(); // error
    }
    function test_setorder_fielquery($t){
        return $m=$this->add('Model_Book')->setOrder('name')->fieldQuery('name');
    }
    function test_setorder_comma($t){
        return $m=$this->add('Model_Book')->setOrder('name,isbn')->dsql();
    }
    function test_setorder_argcomma($t){
        return $m=$this->add('Model_Book')->setOrder('name,isbn',true)->dsql(); // error
    }
    function test_setorder_argboolean($t){
        return $m=$this->add('Model_Book')->setOrder('name',true)->dsql();
    }
    function test_setorder_argkeyword($t){
        return $m=$this->add('Model_Book')->setOrder('name','desc')->dsql();
    }
    function test_setorder_commakeyword($t){
        return $m=$this->add('Model_Book')->setOrder('id desc,isbn,name asc')->dsql();
    }
    function test_setorder_exprfield($t){
        $m=$this->add('Model_Book');
        $m->addExpression('exprfield')->set('now()');
        return $m->setOrder('exprfield')->dsql();
    }
    function test_setorder_expr($t){
        $m=$this->add('Model_Book');
        return $m->setOrder($m->dsql()->expr('now()'))->dsql();
    }
    function test_setorder_fieldobject($t){
        $m=$this->add('Model_Book');
        return $m->setOrder($m->getElement('name'))->dsql();  // same as name
    }
    function test_setorder_chaining($t){
        return $m=$this->add('Model_Book')->setOrder('name','desc')->setOrder('isbn')->dsql();  // same as name
    }
}
