<?php

class page_test extends Page {
	function page_index(){
		$crud=$this->add('CRUD');
		$crud->setModel('Class',array('class_name','section'));
		if($crud->grid){
			$crud->grid->addColumn('Expander','subjects');
		}
	}

	function page_subjects(){
		$this->api->stickyGET('class_master_id');

		$class=$this->add('Model_Class');
		$class->load($_GET['class_master_id']);
	
		$options=array(
				'leftModel' => $class,
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