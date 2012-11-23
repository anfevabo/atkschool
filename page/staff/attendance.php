<?php
class page_staff_attendance extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$grid->setModel('Staff',array('hname','designation','attendance_status','contact'));
	}
}