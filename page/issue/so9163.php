<?php

class Model_Class extends Model_Table {
    public $table='class';
    public $entity_code='class';
public $id_field='idclass';

    function init(){
        parent::init();
    $this->hasOne('Subject','subject_idsubject','name', 'subject_name');
    $this->addField('date_start')->type('date')->caption('Start');
    $this->addField('date_end')->type('date')->caption('End');
    $this->addField('max_students')->type('int');

    $this->hasMany('ClassHasStudent','class_idclass', 'idclass');
		$this->add('dynamic_model/Controller_AutoCreator');
    }
}

  class Model_Student extends Model_Table {
      public $table='student';
      public $entity_code='student';
      public $id_field='idstudent';
      public $title_field='name';

      function init(){
          parent::init();

          $this->addField('student_id')->caption('Student ID');
          $this->addField('name')->caption('Name');
          $this->hasMany('ClassHasStudent', 'student_idstudent', 'idstudent');
		$this->add('dynamic_model/Controller_AutoCreator');
      }
  }

  class Model_ClassHasStudent extends Model_Table {
      public $table='class_has_student';
      public $entity_code='class_has_student';
      public $id_field='idclass_has_student';

      function init(){
          parent::init();

      $this->hasOne('Class','class_idclass','idclass', 'class_name');
          $this->hasOne('Student', 'student_idstudent', 'name', 'student_name');
      $this->addField('date_enrolled')->type('date');
      $this->addField('grade');

		$this->add('dynamic_model/Controller_AutoCreator');
      }

  }

    class Model_Subject extends Model_Table {
      public $entity_code='subject';
  public $id_field='idsubject';


      function init(){
          parent::init();

      $this->addField('name');
      $this->addField('subject_code');
      $this->addField('semester');
      $this->addField('description');
		$this->add('dynamic_model/Controller_AutoCreator');

      }

  }
  class StudentClasses extends Lister {

      function init(){
          parent::init();
      }

      // Override defaultTemplate function.
      function defaultTemplate(){
          return array('page/so9163/class_details');
      }
  }




class page_issue_so9163 extends Page {
	function init(){
		parent::init();

		$this->api->stickyGET('id');

		

	}
    function initMainPage(){

        try {

	        $student = $this->add('Model_Student')->loadAny();
	        $student_detail= $this->add('Model_Class');
	        $student_detail->join('class_has_student.class_idclass','idclass')->addField('student_idstudent');
	        $student_detail->addCondition('student_idstudent',$student->id);
	        $view=$this->add('View',null,null,array('page/so9163/student_details'));
	        $ClassList = $view->add('StudentClasses', null, 'ClassList');

	        $view->setModel( $student );
	        $ClassList->setModel( $student_detail );
	    }catch(Exception $e){
	    	$this->add('View_Error')->set('You must add some data first, then refresh page');
	    }

    	$this->add('CRUD')->setModel('Subject');
    	$this->add('CRUD')->setModel('Class');
    	$this->add('CRUD')->setModel('Student');
    	$this->add('CRUD')->setModel('ClassHasStudent');


    }
}