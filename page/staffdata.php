<?php
class page_staffdata extends Page {
	function init(){
		parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('staff_movement','Staff Inward/Outword');
		$tabs->addTabURL('staff_add','Add Staff');
	}
}