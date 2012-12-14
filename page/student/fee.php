<?php
class page_student_fee extends Page{
	function page_index(){
		// parent::init();

		$form=$this->add('Form',null,null,array('form_horizontal'));
		$field_class=$form->addField('dropdown','class')->setEmptyText('----')->setAttr('class','hindi');
		$field_class->setModel('Class');
		$form->addSubmit('GetList');

		$grid=$this->add('Grid');

		$sc=$this->add('Model_Students_Current');

		if($_GET['filter']){
			if($_GET['class']) $sc->addCondition('class_id',$_GET['class']);
		}else{
			$sc->addCondition('class_id',-1);
		}

		$grid->setModel($sc,array('name','fname','roll_no','ishostler','isScholared','store_no','isalloted','bpl'));
		$grid->addColumn('Expander','deposit','Fee Deposit');
		// $grid->addFormatter('scholar','hindi');

		if($form->isSubmitted()){
			$grid->js()->reload(array("class"=>$form->get('class'),
										"filter"=>1))->execute();

		}

	}
	
	function page_deposit(){
		$this->api->stickyGET('student_id');
		$fa=$this->add('Model_Fees_Applicable');
		$fa->addCondition('student_id',$_GET['student_id']);
		
		$this->add('Button','add_fee')->setLabel('ABCD')->js('click',$this->js()->univ()->frameURL('pFrame Title',$this->api->url('./new',array('var1'=>2344))));
		$crud=$this->add('CRUD',array('allow_add'=>false));
		$crud->setModel($fa,array('fee_class_mapping','amount','paid'));

	}

	function page_deposit_new(){
		$this->add('Text')->set($_GET['var1']);
	}
}