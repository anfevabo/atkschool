<?php

class page_masters_fee extends Page{
	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('Fee');

		if($crud->grid){
		$crud->grid->addColumn('expander','classassociation','ClassAssociation');
	}
}


	function page_classassociation(){

		$this->api->stickyGET('fee_id');

		$fee=$this->add('Model_Fee');
		$fee->load($_GET['fee_id']);
	
		$options=array(
				'leftModel' => $fee,
				'mappingModel' => 'FeeClassMapping',
				'leftField' => 'fee_id',
				'rightField' => 'class_id',
				'rightModel' => 'Class',
				'deleteFirst' => true,
				'maintainSession' => true
			);		
		// $this->add('View')->set('Hi');
		$p=$this->add('View_Mapping',$options);
	}


	
}