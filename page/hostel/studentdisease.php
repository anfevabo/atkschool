<?php
class page_hostel_studentdisease extends Page{
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$form=$this->add('Form');
		$form->addField('dropdown','treatment','Filter For')->setValueList(array('all'=>'All', 'nt'=>'Not Treated','t'=>'Treated'));
		$form->addSubmit('Filter');

		$crud=$this->add('CRUD');

		
		$m=$this->add('Model_Students_Disease');
		if($_GET['filter']){
			switch ($_GET['filter']) {
				case 'nt':
					$temp=0;
					break;
				case 't':
					$temp=1;
					break;
				default:
					$temp = false;
					break;
			}
			if($temp !== false)	$m->addCondition('treatment',$temp);
		}

		$m->_dsql()->order('treatment_date','desc');
		$crud->setModel($m);
		if($crud->grid){
			
			if($form->isSubmitted()){
				$crud->grid->js()->reload(array('filter'=>$form->get('treatment')))->execute();
			}

			$crud->grid->setFormatter('student','hindi');
			$crud->grid->setFormatter('disease','hindi');

		}
		if($crud->form){
			$c=$this->add('Model_Class');
			$crud->form->getElement('student_id')->setAttr('class','hindi');
			$crud->form->getElement('disease_id')->setAttr('class','hindi');
			$class_field=$crud->form->addField('dropdown','class')->setEmptyText("---");
			$class_field->setModel($c);
			if($_GET['class_idx']){
				$crud->form->getElement('student_id')->dq->where('class_id',$_GET['class_idx']);
			}else{ // on form load
				$crud->form->getElement('student_id')->dq->where('class_id',-1);
			}
			$class_field->js('change',$crud->form->js()->atk4_form('reloadField','student_id',array($this->api->getDestinationURL(), 'class_idx'=>$class_field->js()->val())));
		
			$crud->form->add('Order')->move('class','before','student_id')->now();
		}
	}
}