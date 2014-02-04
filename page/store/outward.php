<?php
class page_store_outward extends Page{
	function init(){
		parent::init();
		$item_consume=$this->add('Model_Consume');
		$cols=$this->add('Columns');
		$col1=$cols->addColumn(6);
		$col2=$cols->addColumn(6);
		$form=$col1->add('Form');
		$item_consume->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
		$form->setModel($item_consume);
		$form->getElement('item_id')->addClass('hindi');
		$form->addSubmit('Consume');
		$crud=$this->add('CRUD',array('allow_add'=>false));
		$item_consume->_dsql()->order('id','desc');
		$crud->setModel($item_consume,array('item','quantity','remarks','unit','date'));
		if($crud->grid){
		$crud->grid->addQuickSearch(array('item','unit','quantity'));
		$crud->grid->addPaginator(10);
		$crud->grid->addFormatter('item','hindi');
		// $crud->grid->addFormatter('remarks','hindi');
			
		}
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,array($form->js()->reload(),$crud->js()->reload()))->univ()->successMessage('Inward Successfully')->closeDialog()->execute();
		}

	}
}