<?php
class page_store_meshconsume extends Page{
	function init(){
		parent::init();
		$this->api->stickyGET('party_id');
		$form=$this->add('Form');
		$item_consume=$this->add('Model_Mesh_ItemConsume');
		$item_consume->addCondition('party_id',$_GET['party_id']);
		$item_consume->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
		$form->setModel($item_consume);
		$form->getElement('item_id')->addClass('hindi');
		$form->addSubmit('Consume');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->reload())->univ()->successMessage('Inward Successfully')->closeDialog()->execute();
		}
	}
}