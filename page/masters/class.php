<?php

class page_masters_class extends Page {
	function init(){
		parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('Class');
	}
}