<?php
class page_staff_attendance extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$grid=$this->add('Grid');
		// $grid=$this->add('CompleteLister',null,null,array('list/staffregister'));
		$grid->setModel('Staff',array('hname','designation','attendance_status','contact'));
	}
}