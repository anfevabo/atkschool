<?php
class page_masters_division extends Page{
	function init(){
		parent::init();

		$crud=$this->add("CRUD");
		$crud->setModel("Division");
	}

}