<?php
class page_model1cached extends page_model1 {
    public $author_class='Model_AuthorCached';
}
class Model_AuthorCached  extends Model_Author {
    function init(){
        parent::init();

        $this->addCache('Session');
    }
}
