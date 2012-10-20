<?php
// Testing for field flags -> system(), hidden() and then checking if they appear in actual fields

/*
 * https://groups.google.com/forum/?fromgroups=#!topic/agile-toolkit-devel/v2xVYsRqFpY
This was not clearly defined from the very start :)  Let’s try to get a concept together all of us and then stick to it.


system - field will be loaded by model always , even if not present in actual fields. Setting system to true will also hide the field, but it can be un-hidden.
hidden - field does not appear in the grid, form etc unless specifically added or requested by actual fields
editable / visible - overrides hidden but for only particular widgets. E.g. if field is hidden, but editable it will appear on the form, but not in grid. Setting editable(false) will hide field from form even if it’s not hidden.
readonly - the field will appear on the editable form but will be displayed using read-only field.

none of the field actually impacts the ability of the model to save / load the actual fields when used directly. They are used by Controller_MVCForm, Controller_MVCGrid, etc. 

note: switches can have 3 values - true, false and undefined. Some switches change the value of other switches, such as system would hide field. Some fields may override the methods , such as Field_Expression would set editable=false by default and readonly would always return true.

This is just a concept which makes sense, it’s not 100% aligned to the current implementation. 

 */


class page_fieldflags extends Page_Tester {

    function prepare(){
        return $this->add('Model_Book');
    }
    function test_test1($m){
        $m->addField('test')->system(true);

        return $m->selectQuery();
    }
}
