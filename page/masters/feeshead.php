<?php

class page_masters_feeshead extends Page{
	function init(){
		parent::init();
		$crud=$this->add('CRUD');
		$crud->setModel('FeesHead');
	}
}