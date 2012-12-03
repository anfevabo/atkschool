<?php

class page_schooldata extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$tabs=$this->add('Tabs');
		$tabs->addtabURL('student_rollnoallotment','Roll Numbers');
		$tabs->addtabURL('school_scholars','Sessions Students');
		$tabs->addtabURL('school_studentClassMapping','Student Class Association');
	}
}