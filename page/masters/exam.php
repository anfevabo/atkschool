<?php

class page_masters_exam extends Page {
	function page_index(){
		// parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('Exam');
		if($crud->grid){
			$crud->grid->addColumn('Expander','associated_class');
			$crud->grid->addColumn('Expander','associated_subjects');
		}
	}

	function page_associated_class(){
		$this->api->stickyGET('exam_master_id');

		$exam=$this->add('Model_Exam');
		$exam->load($_GET['exam_master_id']);
	
		$options=array(
				'leftModel' => $exam,
				'mappingModel' => 'ExamClassMap',
				'leftField' => 'exam_id',
				'rightField' => 'class_id',
				'rightModel' => 'Class',
				'deleteFirst' => true,
				'maintainSession' => true
			);		
		// $this->add('View')->set('Hi');
		$p=$this->add('View_Mapping',$options);
	}

	function page_associated_subjects(){
		$this->api->stickyGET('exam_master_id');

		$exam=$this->add('Model_Exam');
		$exam->load($_GET['exam_master_id']);

		$options=array(
				'leftModel' => $exam,
				'mappingModel' => 'ExamClassMap',
				'leftField' => 'exam_id',
				'rightField' => 'class_id',
				'rightModel' => 'Class',
				'deleteFirst' => true,
				'maintainSession' => true,
				'allowediting' => false,
				'onlymapped' => true
			);		
		// $this->add('View')->set('Hi');
		$p=$this->add('View_Mapping',$options);
		if($p->grid){
			$p->grid->addColumn('Expander','subject_mapping');
			$p->grid->addFormatter('exam','hindi');
			$p->grid->addFormatter('class','hindi');
		}
	}

	function page_associated_subjects_subject_mapping(){
		$this->api->stickyGET('exam_map_id');

		$examClassMap=$this->add('Model_ExamClassMap');
		$examClassMap->load($_GET['exam_map_id']);

		$class=$this->add('Model_Class');
		$class->load($examClassMap['class_id']);

		$subject_class_map = $class->ref('SubjectClassMap');
		$options=array(
				'leftModel' => $examClassMap,
				'mappingModel' => 'ExamClassSubjectMap',
				'leftField' => 'exammap_id',
				'rightField' => 'subject_id',
				'rightModel' => $subject_class_map,
				'deleteFirst' => true,
				'maintainSession' => true,
				'allowediting' => true,
				'onlymapped' => false,
				'field_other_then_id'=>'subject_id' //from right model HOPE SO ...
			);		
		$p=$this->add('View_Mapping',$options);
		if($p->grid){
			$p->grid->addFormatter('class','hindi');
			$p->grid->addFormatter('subject','hindi');
		}

	}

}