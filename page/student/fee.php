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
		$this->add('Button','fee_manage')->setLabel('Manage Deposit Fees')->js('click',$this->js()->univ()->frameURL('Manage Deposit Fees',$this->api->url('./manage_deposit',array('student_id'=>$_GET['student_id']))));
		$crud=$this->add('CRUD',array('allow_add'=>false,'allow_del'=>false));
		
		if($crud->grid){
			$crud->grid->addClass('fee_applicable');
			$crud->grid->js('reload',$crud->grid->js()->reload());
		}

		$crud->setModel($fa,array('fee_class_mapping','amount','paid','due'));

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
					// $fee_app->debug();
					$fee_app->tryLoadAny();
					if(!$fee_class_map->loaded()) throw $this->exception("Somthing done Wrong with this entry, Of particluar student");

					$amount_for_this_fee = ($fee_app['due'] >= $amount_to_adjust)? $amount_to_adjust: $fee_app['due'];
					// throw $this->exception("Paid ". $fee_app['paid']);

					// Add deposite row
					// substract from this feeapp due 
					// recalculate 

					if($amount_for_this_fee == 0 ) continue;

					$fee_deposit=$this->add('Model_Fees_Deposit');
					$fee_deposit['paid']=$amount_for_this_fee;
					$fee_deposit['deposit_date']=$form->get('submitted_on');
					$fee_deposit['fee_applicable_id']=$fee_app->id;
					$fee_deposit->save();

					// $fee_app['due'] = $fee_app['due'] - $amount_for_this_fee;
					// $fee_app->save();

					$amount_to_adjust = $amount_to_adjust - $amount_for_this_fee;

				}

				if($amount_to_adjust > 0 ) throw $this->exception('Exxcess fee deposited '.$amount_to_adjust);
			}catch(Exception $e){
					$form->api->db->rollback();
					// $form->js()->univ()->errorMessage($e->getMessage())->execute();
					throw $e;
			}
			$form->api->db->commit();
			$form->js(null,
					$form->js()->_selector('.fee_applicable')->trigger('reload')
				)->univ()->closeDialog()->execute();
			$form->js(null,$this->js()->reload())->univ()->successMessage("Student Record Upadated success fully ")->execute();
		}


	} 


	function page_deposit_new_detailed(){
		
		$this->api->stickyGET('student_id');

		$form=$this->add('Form');

		$feehead_field=$form->addField('dropdown','fees_head')->setEmptyText('-----');

		$fees_field=$form->addField('dropdown','fees')->setEmptyText('-----');

		$form->addField('line','amount_submit')->setNotNull();
		$form->addField('line','receipt_number');
		// $form->addField('text','remarks');
		$form->addField('DatePicker','submitted_on')->set(date('Y-m-d'));
		$form->addSubmit('Receive');



		$feehead=$this->add('Model_FeesHead');
		$fee=$this->add('Model_Fee');

		if($_GET['feehead_id']){
			$fee->addCondition('feehead_id',$_GET['feehead_id']);
		}

		$feehead_field->setModel($feehead);
		$fees_field->setModel($fee);

		// $crud=$this->add('CRUD',array("allow_add"=>false));

		// $fs=$this->add("Model_Fees_Deposit");
		

		// $crud->setModel($fs);

		$feehead_field->js('change',$form->js()->atk4_form('reloadField','fees',array($this->api->url(),'feehead_id'=>$feehead_field->js()->val())));	

		if($form->isSubmitted()){
			try{

				
				$form->api->db->beginTransaction();
				$student=$this->add('Model_Student');
				$student->load($_GET['student_id']);
				$class_id=$student['class_id'];

				$f=$this->add('Model_Fee');
				$f->load($form->get('fees'));

				$amount_to_submit=$form->get('amount_submit');


				foreach($fee as $fee_junk){
					if($amount_to_submit==0) break;
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

					$amount_for_this_fee= ($fee_app['due'] >= $amount_to_submit)? $amount_to_submit: $fee_app['due'];
					// Add deposite row
					// substract from this feeapp due 
					// recalculate 
					if($amount_for_this_fee != 0 ) {
						$fee_deposit=$this->add('Model_Fees_Deposit');
						$fee_deposit['paid']=$amount_for_this_fee;
						$fee_deposit['receipt_number']=$form->get('receipt_number');
						$fee_deposit['deposit_date']=$form->get('submitted_on');
						$fee_deposit['fee_applicable_id']=$fee_app->id;
						$fee_deposit->save();

						// $fee_app['due'] = $fee_app['due'] - $amount_for_this_fee;
						// $fee_app->save();
					}
					$amount_to_submit = $amount_to_submit - $amount_for_this_fee;


				}
				if($amount_to_submit > 0 ) throw $this->exception('Exxcess fee deposited');
			}catch(Exception $e){
					$form->api->db->rollback();
					// $form->js()->univ()->errorMessage($e->getMessage())->execute();
					throw $e;
			}
			$form->api->db->commit();
			$form->js(null,$this->js()->reload())->univ()->successMessage("Student Record Upadated success fully ")->execute();


		}

	}

	function page_deposit_manage_deposit(){
		$this->api->stickyGET('student_id');

		$fee_applicable=$this->add('Model_Fees_Applicable');
		$fee_applicable->addCondition('student_id',$_GET['student_id']);

		$fee_applicable_array=array();

		foreach ($fee_applicable as $fee_applicable_junk) {
			$fee_applicable_array[]=$fee_applicable->id;
		}

		// echo "<pre>";
		// print_r($fee_applicable_array);
		// echo "</pre>";

		$crud=$this->add('CRUD',array('allow_add'=>false));
		$fd=$this->add('Model_Fees_Deposit');
		$fd->addCondition('fee_applicable_id','in',$fee_applicable_array);

		// $fd->debug();
		$crud->setModel($fd,array('paid','deposit_date','receipt_number'),array('fee_applicable_id','paid','deposit_date','receipt_number'));
	}
}