<?php
class page_ajaxec extends Page {
    function init(){
        parent::init();

        $this->js(true,"
$.each({
  increment: function(){
      this.jquery.val(parseInt(this.jquery.val())+1);
  }
},$.univ._import);

");

        $this->add('Text')->set('No matter how many times you click the button within 2-second interval, it should only increase value by one');
        $form=$this->add('Form');
        $field=$form->addField('line','counter')->set(0);

        if($form->addButton()->isClicked()){
            sleep(2);
            $field->js()->univ()->increment()->execute();
        }

        $form->addSubmit('Submit');

        if($form->isSubmitted()){
            sleep(2);
            $field->js()->univ()->increment()->execute();
        }
    }
}
