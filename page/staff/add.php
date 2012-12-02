<?php

class page_staff_add extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$crud = $this->add('CRUD',$acl->getPermission());
		$crud->setModel('Staff',null,array('hname','designation','contact','image_url'));
	}
}