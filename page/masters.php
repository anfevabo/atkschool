<?php

class page_masters extends Page{
	function init(){
		parent::init();
		$tab=$this->add('Tabs');
		$tab->addTabURL('masters_session','Session');
		$tab->addTabURL('masters_class','Class');
		$tab->addTabURL('masters_subject','Subject');
		$tab->addTabURL('masters_exam','Exam');
		$tab->addTabURL('masters_hostel','Hostel');
		$tab->addTabURL('masters_category','Category');
		$tab->addTabURL('masters_item','Item');
		$tab->addTabURL('masters_party','Party');
		$tab->addTabURL('masters_feehead','Fees Head');
	}
}