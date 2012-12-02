<?php

class page_store_itemoutward extends Page {
	function page_index(){
		$acl=$this->add('xavoc_acl/Acl');
		$form=$this->add('Form');
		$grid=$this->add('Grid');
		$form->addField('line','store_no')->setNotNull();
		$form->addField('DatePicker','for_date')->setNotNull()->set(date('Y-m-d'));
		$form->addSubmit('Get Details');

		$m=$this->add('Model_Students_Current');
		if($_GET['store_no']){
			$m->addCondition('store_no',$_GET['store_no']);
		}else{
			$m->addCondition('id',-1);
		}
		$grid->setModel($m,array('name','class'));
		$grid->addFormatter('class','hindi');
		$grid->addColumn('Expander','allot_item');

		if($form->isSubmitted()){
			$grid->js()->reload(array('store_no'=>$form->get('store_no')))->execute();
		}
	}

	function page_allot_item(){
		$this->api->stickyGET('student_id');
		$this->add('Text')->set($_GET['student_id']);
	}
}