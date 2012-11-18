<?php

class page_staff_add extends Page {
	function init(){
		parent::init();

		$crud = $this->add('CRUD');
		$crud->setModel('Staff',null,array('hname','designation','contact'));
	}
}