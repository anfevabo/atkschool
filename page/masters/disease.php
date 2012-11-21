<?php
class page_masters_disease extends Page{
	function init(){
		parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('Diseases');
		
	}
}