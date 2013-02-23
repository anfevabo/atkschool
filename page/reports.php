<?php
class page_reports extends Page{
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$tab=$this->add('Tabs');
		$tab->addTabURL('student_report','Student Report');
		$tab->addTabURL('hostel_attendence','Student Attendence');
		$tab->addTabURL('store_reports','Store Reports');
		$tab->addTabURL('student_contact','Students Contact No List');
		$tab->addTabURL('student_feechart','Fee wise Chart');
		$tab->addTabURL('student_marksheet','Marksheet');
	}
}