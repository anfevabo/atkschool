<?php

class page_masters_category extends Page{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('Item_Category');
	}
}