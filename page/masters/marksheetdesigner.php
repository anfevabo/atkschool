<?php
class page_masters_marksheetdesigner extends Page{
	function page_index(){
		// parent ::init();
		
		$crud=$this->add("CRUD");

		$crud->setModel("MarksheetDesigner");
		if($crud->form){
			$crud->form->getElement('class_id')->setAttr('class','hindi');
		}

		if($crud->grid){
			$crud->grid->addColumn("Expander","mainblock","Main Block");
			$crud->grid->setFormatter('class','hindi');
		}

	}

	function page_mainblock(){
		$this->api->stickyGET('marksheet_designer_id');

		$md=$this->add('Model_MarksheetDesigner')->load($_GET['marksheet_designer_id']);
		$cls=$md['class_id'];
		$this->api->memorize('marksheet_class',$md['class_id']);

		$crud=$this->add("CRUD");
		$mb=$this->add("Model_MainBlock");
		$mb->addCondition('marksheet_designer_id',$_GET['marksheet_designer_id']);
		/*$mb->addCondition('class_id',$this->api->recall('marksheet_class'));*/
		$crud->setModel($mb);

		if($crud->grid){
			$crud->grid->addColumn("Expander","mainblockexams","Main Block Exam");
		}
	}

	function page_mainblock_mainblockexams(){
		$this->api->stickyGET('main_block_id');

		$crud=$this->add("CRUD");
		$mbe=$this->add("Model_MainBlockExam");
		$mbe->addCondition('main_block_id',$_GET['main_block_id']);
		$crud->setModel($mbe);
		if($crud->form){
			$crud->form->getElement('exammap_id')->model->_dsql()->where('class_id',$this->api->recall('marksheet_class'));
			$crud->form->getElement('exammap_id')->setAttr('class','hindi');
		}
		if($crud->grid){
			$crud->grid->setFormatter('exammap','hindi');
		}
	}

}