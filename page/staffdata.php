<?php
class page_staffdata extends Page {
	function init(){
		parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('staff_movement','Staff Inward/Outword');
		$tabs->addTabURL('staff_movement_record','Movement Record');
		$tabs->addTabURL('staff_add','Add Staff');
		$tabs->addTabURL('staff_attendance','Staff AttenDance');
	}
}