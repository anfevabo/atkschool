<?php
class page_student_msview extends Page {
	function init(){
		parent::init();

		$c=$this->add('Model_Class')->load($_GET['class']);

		$topStudentView=$this->add('View_MS_StudentDetails',null,'student_panel');
		$topStudentView->setModel($this->add('Model_Student')->load($_GET['student']));
		$first=true;

		foreach($marksheet=$c->ref('MS_Designer') as $marksheet_junk){
			foreach($section = $marksheet->ref('MS_Sections') as $section_junk){
				$v=$this->add('View_MS_MainBlock',array('class'=>$_GET['class'],'student'=>$_GET['student'],'section'=>$section->id,'save_results'=>$first));
				$first=false;
			}
		}
		$result=array('percentage'=>$this->api->recall('percentage'));
		$this->add('View_MS_Result',array('result'=>$result),'right_panel');

	}

	function defaultTemplate(){
		return array('view/marksheet/backside');
	}

	function render(){
		$this->api->template->del('logo');
		$this->api->template->del('Menu');
		$this->api->template->del('date');
		$this->api->template->del('welcome');
		$this->api->template->del('footer_text');

		parent::render();
	}
}