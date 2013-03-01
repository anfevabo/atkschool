<?php

class page_staff_add extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$crud = $this->add('CRUD',$acl->getPermissions());
		if($crud->grid)
			$crud->grid->addColumn('sno','sno');
		$crud->setModel('Staff',null,array('hname','designation','contact','image_url'));
	
	}
}