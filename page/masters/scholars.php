<?php
class page_masters_scholars extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$crud = $this->add('CRUD',array("allow_add"=>false,"allow_del"=>false));
		if($crud->grid){
		$crud->grid->addPaginator(10);
		$crud->grid->addColumn('sno','sno');
	}	
			
		$sc=$this->add('Model_Scholars_Current');
		$sc->_dsql()->del('order')->order('scholar_no','desc');
		// $sc->_dsql()->order('fname','asc');
		$crud->setModel($sc);
		if($crud->form){
			$crud->form->getElement('class_id')->setAttr('class','hindi');
		}
		if($crud->grid){
		$crud->grid->setFormatter('class','hindi');
		$crud->grid->addQuickSearch(array('fname','scholar_no'));
		}
	}
}