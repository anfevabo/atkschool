<?php

class View_MS_Front extends View{
	var $student;

	function init(){
		parent::init();

	}

	function setModel($m){
		parent::setModel($m);
		$student=$m->ref('Student')->addCondition('session_id',$this->add('Model_Sessions_Current')->fieldQuery('id'))->tryLoadAny();
		$this->template->trySet('class',$student->ref('class_id')->get('name'));
		$this->template->trySet('roll_no',$student['roll_no']);
		$this->template->trySet('dob1',date('d/m/Y',strtotime($m['dob'])));
	}

	function defaultTemplate(){
		return array('view/marksheet/front');
	}
}