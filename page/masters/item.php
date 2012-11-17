<?php

class page_masters_item extends Page{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('Item');

		if($crud->form){
			$crud->form->getElement('category_id')->setEmptyText('---')->setAttr('class','hindi');
		}

		if($crud->grid){
			$crud->grid->addFormatter('category', 'hindi');
		}
	}
}