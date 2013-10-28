<?php
class page_deepref extends Page_Tester {

    function init() {
        parent::init();
        $this->skipTests('Not ready');
    }


    function test_loaded_one($b){
        return $b->load(1)->ref('author_id');
    }
    function test_loaded_many($b){
        return $b->load(1)->ref('Chapter');
    }
    function test_cond_one($b){
        return $b->addCondition('id',1)->ref('author_id');
    }
    function test_cond_many($b){
        return $b->addCondition('id',1)->ref('Chapter');
    }
    function test_cond_many2($b){
        return $b->addCondition('id',1)->ref('Chapter')->addCondition('no',2);
    }
    function test_loaded_deep1($b){
        // address of associated author
        return $b->load(1)->ref('author_id/my_contact');
    }
    function test_loaded_deep2($b){
        // all books of the same author
        return $b->load(1)->ref('author_id/Book');
    }
    function test_loaded_deep3($b){
        // roundtrip to same book
        return $b->load(1)->ref('Chapter/book_id');
    }
    function test_loaded_deep4($b){
        // same as all books of the same author
        return $b->load(1)->ref('Chapter/book_id/author_id/Book');
    }
    function test_deep5($b){
        // same but without initial value
        return $b->ref('Chapter/book_id/author_id/Book');
    }
    function test_cond_deep6($b){
        // with condition
        return $b->addCondition('id',1)->ref('Chapter/book_id/author_id/Book');
    }
    function test_custom_model1($b){
        // with custom model class
        return $b->addCondition('id',1)->ref('Chapter','FirstChapter');
    }
    function test_custom_model2($b){
        // with predefined object
        return $b->addCondition('id',1)->ref('Chapter',$this->addModel('Model_Chapter')->addCondition('no',2));
    }
    function test_refsql($b){
        // refsql with predefined object
        $b->addExpression('chapters')->set(function($m){ return $m->refSQL('Chapter')->count(); });
        return $b;
    }
    function test_refsql2($b){
        // refsql with predefined object
        $b->addExpression('chapters')->set(function($m){ return $m->refSQL('Chapter','FirstChapter')->count(); });
        return $b;
    }
    function test_refsql_deep($b){
        // deep refsql
        $b->addExpression('sections')->set(function($m){ return $m->refSQL('Chapter/Section')->count(); });
        return $b;
    }
    function test_refsql_getfield($b){
        // refsql fieldquery
        $b->addExpression('author')->set(function($m){ return $m->refSQL('author_id')->fieldQuery('name'); });
        return $b;
    }
    function test_refsql_getfield_deep($b){
        // deep refsql field query
        $b->addExpression('address')->set(function($m){ return $m->refSQL('author_id/address_id')->fieldQuery('address1'); });
        return $b;
    }
    function test_selfref($b){
        // father of author is a person / same object
        return $b->load(1)->ref('author_id/father_id');
    }
    function test_selfref2($b){
        // father of father
        return $b->load(1)->ref('author_id/father_id/father_id');
    }
    function test_selfref3($b){
        // kids of a person who wrote book with id=1
        return $b->load(1)->ref('author_id/Kids');
    }
    function test_selfref4($b){
        // kids of a person who wrote book with id=1
        return $b->addCondition('id',1)->ref('author_id/Kids');
    }
    function test_selfref5($b){
        // grand-kids of a person who wrote book with id=1
        return $b->addCondition('id',1)->ref('author_id/Kids/Kids');
    }
}
