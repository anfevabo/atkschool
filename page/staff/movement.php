<?php

class page_staff_movement extends Page {
	function init(){
		parent::init();
		$form=$this->add('Form',null,null,array('form_horizontal'));
		// $grid=$this->add('Grid');
		$filter_field=$form->addField('dropdown','filter_duty')->setValueList(array('h'=>'Hostel','s'=>'School','0'=>'All'))->set('0');
		$staff_field=$form->addField('dropdown','staff')->setEmptyText('---')->setNotNull()->setAttr('class','hindi');
		$form->addButton('Mark In')->js('click',$form->js()->atk4_form('submitForm','mark_in'));
		$form->addButton('Mark Out')->js('click',$form->js()->atk4_form('submitForm','mark_out'));

		$sm= $this->add('Model_Staff');
		if($_GET['filter_duty']){
			$sm->addCondition('ofhostel','like',($_GET['filter_duty']=='h')? '1':'0');
		}

		$staff_field->setModel($sm);
		$filter_field->js('change',$form->js()->atk4_form('reloadField','staff',array($this->api->getDestinationURL(), 'filter_duty'=>$filter_field->js()->val())));

		if($form->isSubmitted()){
			$staff = $this->add('Model_Staff');
			$staff->load($form->get('staff'));
			$m=$staff->ref('Staff_Movement');

			if($form->isClicked('mark_in')){
				if($staff['attendance_status'] == 'inward') $form->displayError('staff','Already In');
				$m['action']="inward";
			}
			if($form->isClicked('mark_out')){
				if($staff['attendance_status'] == 'outward') $form->displayError('staff','Already Out');
				$m['action']="outward";
			}
			$m->save();
			$form->js(null,$form->js()->univ()->successMessage('Movement Recorded'))->reload()->execute();
		}
	}
}