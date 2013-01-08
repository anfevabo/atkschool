<?php
class page_masters_scholars extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$grid = $this->add('Grid');
		$grid->addColumn('sno','sno');
		$sc=$this->add('Model_Scholars_Current');
		// $sc->_dsql()->order('class','asc');
		$grid->setModel($sc,array('admission_date','scholar_no','class','fname','name','father_name',
										'contact','image_url','active_in_session'));
		$grid->setFormatter('class','hindi');
		$grid->addQuickSearch(array('fname'));
		$grid->addPaginator();
	}
}