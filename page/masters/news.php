<?php
class page_masters_news extends Page{
	function init(){
		parent::init();
		$crud=$this->add('CRUD',array('allow_add'=>false,'allow_del'=>false));
		$crud->setModel('News');

		if($crud->form){
			$crud->form->getElement('name')->setAttr('class','hindi');
		}
		if($crud->grid){
			$crud->grid->setFormatter('name','hindi');
		}
	}
	
}