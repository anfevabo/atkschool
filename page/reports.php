<?php
class page_reports extends Page{
	function init(){
		parent::init();
		$tab=$this->add('Tabs');
		$tab->addTabURL('student_report','Student Report');
	}
}