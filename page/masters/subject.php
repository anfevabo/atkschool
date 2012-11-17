<?php
class page_masters_subject extends Page {
	function init(){
		parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('Subject');
	}
}