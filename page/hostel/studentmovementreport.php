<?php

class page_hostel_studentmovementreport extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$crud=$this->add('CRUD',array('allow_add'=>false));
		$m=$this->add('Model_Students_Movement');
		$m->addExpression('guardian_image')->set(function($m,$q){
			return $m->refSQL('gaurdian_id')->fieldQuery('image_url');
		});
		$crud->setModel($m);
		if($crud->grid){
			$crud->grid->setFormatter('student','hindi');
			$crud->grid->setFormatter('purpose','attendance');
			$crud->grid->setFormatter('gaurdian','hindi');
			$crud->grid->setFormatter('guardian_image','picture');
			$crud->grid->addPaginator();
		}
		if($crud->form){
			$crud->form->getElement('student_id')->destroy();
			$crud->form->getElement('gaurdian_id')->destroy();
		}

	}
}