<?php
class page_file extends Page_Tester {
    function prepare(){
        return array($this->add('filestore/Model_File'));
    }
    function test_totalfiles($f){
        return $f->dsql()->field('count(*)')->do_getOne();
    }
    function test_import($f){
        // Imports file
        return $f->import('atk4/templates/shared/images/logo.png','copy')
            ->set('filestore_type_id',$f->getFiletypeID())
            ->save()
            ->get('filename');
    }
    function test_load($f){
        // Imports file
        return $f
            ->setOrder('id',true)
            ->loadAny()
            ->get('filename');
    }

}
