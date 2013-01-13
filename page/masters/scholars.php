<?php
class page_masters_scholars extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$crud = $this->add('CRUD');
		if($crud->grid)
		$crud->grid->addPaginator(10);
		// $crud->grid->addColumn('sno','sno');
		$sc=$this->add('Model_Scholars_Current');
		// $sc->_dsql()->order('fname','asc');
		$crud->setModel($sc,null,array('admission_date','scholar_no','class','fname','name','father_name',
										'dob','contact','image_url','active_in_session'));
		// $crud->grid->setFormatter('class','hindi');
		// $crud->addQuickSearch(array('fname','scholar_no'));
	}
}