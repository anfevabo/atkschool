<?php

class page_masters_party extends Page{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('Party');
	}
}