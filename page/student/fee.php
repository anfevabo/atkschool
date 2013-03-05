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

		$f=$this->add('Model_FeesHead');
		$field_fee=$form->addField('dropdown','fee_head')->setEmptyText("----");
		$field_fee->setModel($f);

		$form->addField('line','amount_submitted')->setNotNull();
		// $form->addField('line','due_amount');
		// $form->addField('text','remarks');
		$form->addField('line','receipt_number');
		$form->addField('DatePicker','submitted_on')->set(date('Y-m-d'));
		$form->addSubmit('Receive');

		if($form->isSubmitted()){
			try{			
				$form->api->db->beginTransaction();
				$student=$this->add('Model_Student');
				$student->load($_GET['student_id']);
				$class_id=$student['class_id'];

				$fee_head=$this->add('Model_FeesHead');
				$fee_head->load($form->get('fee_head'));
				
				$amount_to_adjust=$form->get('amount_submitted');

				foreach($fee=$fee_head->ref('Fee') as $fee_junk){
					if($amount_to_adjust==0) break;
					$fee_class_map=$this->add('Model_FeeClassMapping');
					$fee_class_map->addCondition('fee_id',$fee->id);
					$fee_class_map->addCondition('class_id',$class_id);
					$fee_class_map->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
					$fee_class_map->tryLoadAny();
					if(!$fee_class_map->loaded()) continue;

					$fee_app=$this->add("Model_Fees_Applicable");
					$fee_app->addCondition('fee_class_mapping_id',$fee_class_map->id);
					$fee_app->addCondition('student_id',$student->id);
					$fee_app->tryLoadAny();
					if(!$fee_class_map->loaded()) throw $this->exception("Somthing done Wrong with this entry, Of particluar student");

					$amount_for_this_fee= ($fee_app['due'] >= $amount_to_adjust)? $amount_to_adjust: $fee_app['due'];
					// Add deposite row
					// substract from this feeapp due 
					// recalculate 

					$fee_deposit=$this->add('Model_Fees_Deposit');
					$fee_deposit['paid']=$amount_for_this_fee;
					$fee_deposit['deposit_date']=$form->get('submitted_on');
					$fee_deposit['fee_applicable_id']=$fee_app->id;
					$fee_deposit->save();

					$fee_app['due'] = $fee_app['due'] - $amount_for_this_fee;
					$fee_app->save();

					$amount_to_adjust = $amount_to_adjust - $amount_for_this_fee;

				}

				if($amount_to_adjust > 0 ) throw $this->exception('Exxcess fee deposited');
			}catch(Exception $e){
					$form->api->db->rollback();
					// $form->js()->univ()->errorMessage($e->getMessage())->execute();
					throw $e;
			}
			$form->api->db->commit();
			$form->js(null,$this->js()->reload())->univ()->successMessage("Student Record Upadated success fully ")->execute();
		}


	} 


	function page_deposit_new_detailed(){
		$this->add('Text')->set($_GET['var1']. "sdfs");
	}
}