<?php
class page_student_msview extends Page {
	function init(){
		parent::init();

		$c=$this->add('Model_Class')->load($_GET['class']);
		foreach($marksheet=$c->ref('MS_Designer') as $marksheet_junk){
			foreach($section = $marksheet->ref('MS_Sections') as $section_junk){
				$v=$this->add('View_MS_MainBlock',array('class'=>$_GET['class'],'student'=>$_GET['student'],'section'=>$section->id));
			}
		}
	}

	function defaultTemplate(){
		return array('view/marksheet/backside');
	}
}