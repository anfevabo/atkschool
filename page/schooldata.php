<?php

class page_schooldata extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$tabs->addtabURL('school_scholars','Scholars');
	}
}