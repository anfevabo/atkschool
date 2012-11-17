<?php

class page_masters_exam extends Page {
	function page_index(){
		// parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('Exam');
		if($crud->grid){
			$crud->grid->addColumn('Expander','associated_class');
		}
	}

	function page_associated_class(){
		$this->api->stickyGET('exam_master_id');

		$exam=$this->add('Model_Exam');
		$exam->load($_GET['exam_master_id']);
	
		$options=array(
				'leftModel' => $exam,
				'mappingModel' => 'SubjectClassMap',
				'leftField' => 'class_id',
				'rightField' => 'subject_id',
				'rightModel' => 'Subject',
				'deleteFirst' => true,
				'maintainSession' => true
			);		
		// $this->add('View')->set('Hi');
		$p=$this->add('View_Mapping',$options);
	}
}