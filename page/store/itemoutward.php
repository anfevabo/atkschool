<?php

class page_store_itemoutward extends Page {
	function page_index(){
		$acl=$this->add('xavoc_acl/Acl');
		$form=$this->add('Form');
		$grid=$this->add('Grid');
		$form->addField('line','store_no')->setNotNull();
		$form->addField('DatePicker','for_date')->setNotNull()->set(date('Y-m-d'));
		$form->addSubmit('Get Details');

		$m=$this->add('Model_Hosteler');
		$m->addCondition('session_id',$this->add('Model_Sessions_Current')->fieldQuery('id'));
		if($_GET['store_no']){
			$m->addCondition('store_no',$_GET['store_no']);
		}else{
			$m->addCondition('id',-1);
		}
		$grid->setModel($m,array('name','class'));
		$grid->addFormatter('class','hindi');
		$grid->addColumn('Expander','allot_item');

		if($form->isSubmitted()){
			$this->api->memorize('issue_date',$form->get('for_date'));
			$grid->js()->reload(array('store_no'=>$form->get('store_no')))->execute();
		}
	}

	function page_allot_item(){
		$this->api->stickyGET('student_id');
		// $this->add('Text')->set($_GET['student_id']);
		// $this->add('Text')->set($this->api->recall('date'));
		$ism=$this->add('Model_Item_Issue');
		$ism->addCondition('student_id',$_GET['student_id']);
		$ism->addCondition('date',$this->api->recall('issue_date'));
		// $ism->debug();
		$crud=$this->add('CRUD');
		$crud->setModel($ism,null,array('item','quantity','rate','amount'));
		if($crud->form){
			$crud->form->getElement('item_id')->setAttr('class','hindi');
		}
		if($crud->grid){
			$crud->grid->setFormatter('item','hindi');
		}

	}
}