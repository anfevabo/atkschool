<?php
class page_hostel_studentmovement extends Page{
	function init(){
		parent::init();
		$form=$this->add('Form',null,null,array('form_horizontal'));
		$class_field=$form->addField('dropdown','class')->setEmptyText('-----');
		$student_field=$form->addField('dropdown','student')->setAttr('class','hindi')->setEmptyText('-----');
		$form->addSubmit('Get List');

		$v=$this->add('View_StudentMovement');

		$c=$this->add('Model_Class');
		$s=$this->add('Model_Hosteler');

		if($_GET['class_id']){
			$s->addCondition('class_id',$_GET['class_id']);
		}

		$class_field->setModel($c);
		$student_field->setModel($s);
		$class_field->js('change',$form->js()->atk4_form('reloadField','student',array($this->api->url(),'class_id'=>$class_field->js()->val())));

		$hm=$this->add('Model_Hosteler');
		if($_GET['hostler_id']){
			$hm->addCondition('id',$_GET['hostler_id']);
		}else{
			$hm->addCondition('id',0);
		}
		
		$v->setModel($hm);

		if($form->isSubmitted()){
			// throw $this->exception($form->get('student'));
			$v->js()->reload(array('hostler_id'=>$form->get('student')))->execute();
		}

	}
	
}