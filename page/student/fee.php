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
		$grid->addColumn('sno','sno');
		$grid->setModel($sc,array('sno','name','fname','father_name','ishostler','isScholared'));
		$grid->addColumn('Expander','deposit','Fee Deposit');
		$grid->addFormatter('father_name','hindi');

		if($form->isSubmitted()){
			$grid->js()->reload(array("class"=>$form->get('class'),
										"filter"=>1))->execute();

		}

	}
	
	function page_deposit(){
		$this->api->stickyGET('student_id');
		$fa=$this->add('Model_Fees_Applicable');
		$fa->addCondition('student_id',$_GET['student_id']);
		
		$this->add('Button','add_fee')->setLabel('Fast Deposit')->js('click',$this->js()->univ()->frameURL('Fee Deposit (Fast/auto method)',$this->api->url('./new',array('student_id'=>$_GET['student_id']))));
		$this->add('Button','add_fee_detail')->setLabel('Detailed Deposit')->js('click',$this->js()->univ()->frameURL('Fee Deposit (Detailed)',$this->api->url('./new_detailed',array('student_id'=>$_GET['student_id']))));
		$crud=$this->add('CRUD',array('allow_add'=>false));
		$crud->setModel($fa,array('fee_class_mapping','amount','paid'));

	}

	function page_deposit_new(){
		$this->api->stickyGET('student_id');
		
		$form = $this->add('Form');
		$form->addField('line','amount_submitted')->setNotNull();
		$form->addField('line','receipt_number');
		$form->addField('DatePicker','submitted_on')->set(date('Y-m-d'));
		$form->addSubmit('Receive');

		if($form->isSubmitted()){

			// First check if amount is less then equal to due amount.. do not take surplus amount
			$amount_to_adjust=$form->get('amount_submitted');

			$fa_chk=$this->add('Model_Fees_Applicable');
			$fa_chk->addCondition('student_id',$_GET['student_id']);
			// $fa_chk->_dsql()->delete('field')->field($fa_chk->dsql()->expr('SUM(due)'));
			$total_due=$fa_chk->sum('due')->getOne();
			if($amount_to_adjust > $total_due)
				$form->js()->univ()->errorMessage("Can not take surplus amount, only $total_due is due for ". $_GET['student_id'])->execute();

			$fa=$this->add('Model_Fees_Applicable');
			$fa->addCondition('student_id',$_GET['student_id']);
			$fa->addCondition('due','>',0);

			foreach($fa as $junk){

			}



			$form->js(null,array(
					$form->js()->univ()->closeDialog(),
					$form->js()->univ()->closeExpander())
				)->univ()->successMessage('hi there')->execute();
		}

	}

	function page_deposit_new_detailed(){
		$this->add('Text')->set($_GET['var1']. "sdfs");
	}
}