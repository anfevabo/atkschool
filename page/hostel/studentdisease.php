<?php
class page_hostel_studentdisease extends Page{
	function init(){
		parent::init();
		$crud=$this->add('CRUD');
		$m=$this->add('Model_Students_Disease');
		$m->_dsql()->order('treatment_date','desc');
		$crud->setModel($m);
		if($crud->grid){
			$crud->grid->setFormatter('student','hindi');

		}
		if($crud->form){
			$c=$this->add('Model_Class');
			$crud->form->getElement('student_id')->setAttr('class','hindi');
			$class_field=$crud->form->addField('dropdown','class')->setEmptyText("---");
			$class_field->setModel($c);
			if($_GET['class_idx']){
				$crud->form->getElement('student_id')->dq->where('class_id',$_GET['class_idx']);
			}else{ // on form load
				$crud->form->getElement('student_id')->dq->where('class_id',0);
			}
			$class_field->js('change',$crud->form->js()->atk4_form('reloadField','student_id',array($this->api->getDestinationURL(), 'class_idx'=>$class_field->js()->val())));
		

		}
	}
}