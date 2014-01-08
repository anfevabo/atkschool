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
		$sch=$student->ref('scholar_id');
		$g=$sch->ref('Scholars_Guardian')->setOrder('id','desc')->tryLoadAny();
		// if($g['name']==$sch['mother_name'])
		// 	$g->setOrder('name','asc');
		// else
		// 	$g->setOrder('name','desc');
		$this->template->trySet('guardian_name',$g['gname']);
	}

	function defaultTemplate(){
		return array('view/marksheet/front');
	}
}