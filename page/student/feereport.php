<?php
class page_student_feereport extends Page{
	function page_index(){
		// parent::init();

		$class=$this->add('Model_Class');
		$student=$this->add('Model_Student');



		$form=$this->add('Form',null,null,array('form_horizontal'));
		$field_class=$form->addField('dropdown','class')->setEmptyText("---")->setAttr('class','hindi');

		$field_student=$form->addField('dropdown','student')->setEmptyText("---")->setAttr('class','hindi');

		$form->addField('dropdown','status')->setValueList(array('due'=>'Due',
																'paid'=>'Paid'))->setEmptyText("Select Any");

		$field_class->setModel($class);
		if($_GET['class_id']){
			$student->addCondition('class_id',$_GET['class_id']);
		}
		$field_class->js('change',$form->js()->atk4_form('reloadField','student',array($this->api->url(),'class_id'=>$field_class->js()->val())));
		$field_student->setModel($student);

		$form->addSubmit("Search");

		$grid=$this->add('Grid');

		$fee_applicable=$this->add('Model_Fees_Applicable');
		$fee_applicable_join_student=$fee_applicable->join('student.id','student_id');
		$fee_applicable_join_student->hasOne('Class','class_id');
		// $fee_applicable_join_student->hasOne('Student','student_id');
		$scholar=$fee_applicable_join_student->join('scholars_master.id','scholar_id');
		$scholar->addField('fname');
		// $scholar->addField('amount');

		$fee_applicable_join_feeclassmapping=$fee_applicable->join('fee_class_mapping.id','fee_class_mapping_id');
		$fee_applicable_join_feeclassmapping_join_fee=$fee_applicable_join_feeclassmapping->join('fee.id','fee_id');
		$fee_applicable_join_feeclassmapping_join_fee->addField('FeeName','name');
		if($_GET['filter']){
			if($_GET['class']) $fee_applicable->addCondition('class_id',$_GET['class']);
			if($_GET['student']) $fee_applicable->addCondition('student_id',$_GET['student']);

			if($_GET['status']){
				if($_GET['status']=='paid') $fee_applicable->addCondition('due',0);
				if($_GET['status']=='due') $fee_applicable->addCondition('due','<>',0);
			}
		}


		$grid->setModel($fee_applicable,array('fname','FeeName','amount','paid','due'))	;
		$grid->addPaginator(10);

		$grid->addColumn('expander','details','Deposite Details');

		if($form->isSubmitted()){
			$grid->js()->reload(array('class'=>$form->get('class'),
											'student'=>$form->get('student'),
											'status'=>$form->get('status'),
											'filter'=>1))
											->execute();
		}
	}

	function page_details(){

		$this->api->stickyGET('fee_applicable_id');

		$fd=$this->add('Model_Fees_Deposit');
		$fd->addCondition('fee_applicable_id',$_GET['fee_applicable_id']);

		$grid=$this->add('Grid');
		$grid->setModel($fd);

	}
}