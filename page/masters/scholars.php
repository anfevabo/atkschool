<?php
class page_masters_scholars extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$grid = $this->add('Grid');
		$grid->setModel('Scholar',array('admission_date','scholar_no','fname','name','father_name',
										'contact','image_url','active_in_session'));
		$grid->addQuickSearch(array('fname'));
		$grid->addPaginator();
	}
}