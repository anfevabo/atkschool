<?php
class page_masters_scholars extends Page {
	function init(){
		parent::init();
		$grid = $this->add('Grid');
		$grid->setModel('Scholar',array('admission_date','scholar_no','name','father_name',
										'contact','image_url','isActive'));
		$grid->addPaginator();
	}
}