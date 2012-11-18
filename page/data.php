<?php

class page_data extends Page{
	function init(){
		parent::init();

		$tab=$this->add('Tabs');
		$tab->addTabURL('masters_hostelallotement','Hostel Allotement');
	}
}