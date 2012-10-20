<?php
class page_order extends Page_DBTest {

    function test_order1($t){
        return $t->table('bar')->order('foo');
    }
    function test_order_keyword($t){
        return $t->table('bar')->order('foo desc');
    }
    function test_order_wrong_keyword($t){
        return $t->table('bar')->order('foo bleh');  // error
    }
    function test_order_arg1($t){
        return $t->table('bar')->order('foo','desc');
    }
    function test_order_arg2($t){
        return $t->table('bar')->order('foo',true);
    }
    function test_order_commas($t){
        return $t->table('bar')->order('foo,bar desc,baz asc');
    }
    function test_order_argcommas($t){
        return $t->table('bar')->order('foo,bar desc,baz asc',true); // error
    }
    function test_order_chaining($t){
        return $t->table('bar')->order('foo')->order('bar','desc');
    }
    function test_order_dots($t){
        return $t->table('bar')->order('table.foo,table.bar');
    }
    function test_order_noexpr($t){
        return $t->table('bar')->order('now()'); // error
    }
    function test_order_expr($t){
        return $t->table('bar')->order($t->expr('now()'));
    }
    function test_order_concat($t){
        return $t->table('bar')->order($t->concat('name','surname'));
    }
    function test_order_field($t){
        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->addField('name'));
    }
    function test_order_fieldexpr($t){
        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->addExpression('now()'));
    }
    function test_order_subquery($t){

        $m=$this->add('Model_Book');
        return $m->dsql()->order($m->refSQL('author_id')->feldQuery($m->addField('name')));
           // select * from book order by (select name from author where book.author_id=author.id)
    }
    function test_setorder($t){
        // Model ordering
        $m=$this->add('Model_Book')->setOrder('foo')->dsql();
    }
    function test_setorder_nofield($t){
        $m=$this->add('Model_Book')->setOrder('nosuchfield')->dsql(); // error
    }
    function test_setorder_thenfieldexpr($t){
        $m=$this->add('Model_Book')->setOrder('foo')->fieldExpr('name');
    }
    function test_setorder_comma($t){
        $m=$this->add('Model_Book')->setOrder('foo,bar')->dsql();
    }
    function test_setorder_argcomma($t){
        $m=$this->add('Model_Book')->setOrder('foo,bar',true)->dsql(); // error
    }
    function test_setorder_argboolean($t){
        $m=$this->add('Model_Book')->setOrder('foo',true)->dsql();
    }
    function test_setorder_argkeyword($t){
        $m=$this->add('Model_Book')->setOrder('foo','desc')->dsql();
    }
    function test_setorder_commakeyword($t){
        $m=$this->add('Model_Book')->setOrder('foo desc,bar,baz asc')->dsql();
    }
    function test_setorder_exprfield($t){
        $m=$this->add('Model_Book')->setOrder('exprfield')->dsql();
    }
    function test_setorder_expr($t){
        $m=$this->add('Model_Book')->setOrder($m->dsql()->expr('now()'))->dsql();
    }
    function test_setorder_fieldobject($t){
        $m=$this->add('Model_Book');
        $m->setOrder($m->getElement('name'))->dsql();  // same as name
    }
    function test_setorder_chaining($t){
        $m=$this->add('Model_Book')->setOrder('foo desc')->setOrder('bar')->dsql();  // same as name
    }
}
