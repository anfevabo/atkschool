<?php
class page_student_msview extends Page {
	function init(){
		parent::init();
		$v=$this->add('View_MS_MainBlock',array('class'=>$_GET['class'],'student'=>$_GET['student'],'in_block'=>1));
		$v=$this->add('View_MS_MainBlock',array('class'=>$_GET['class'],'student'=>$_GET['student'],'in_block'=>2));
	}

	function defaultTemplate(){
		return array('view/marksheet/backside');
	}
}