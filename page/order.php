<?php
class page_order extends Page_DBTest {

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
        return $t->table('book')->order('book.name,book.isbn');
    }
    function test_order_noexpr($t){
        return $t->table('book')->order('now()'); // error
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
        return $m=$this->add('Model_Book')->setOrder('name','asc')->dsql();
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
