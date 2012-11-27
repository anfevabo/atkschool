<?php
class View_StudentMovement extends View{
	var $information_grid;
	var $form;
	var $gaurdian_grid;
	var $hosteler;
	function init(){
		parent::init();
		$this->information_grid=$this->add('Grid');
		$this->gaurdian_grid=$this->add('Grid');
		$this->form = $this->add('Form',NULL,NULL,array('form_horizontal'));
		$array = array('inward' => 'inward', 'outward' => 'outward', 'enquiry' => 'enquiry');//, 'card outward'=>'Card Outward','self outward'=>'Self Outward','card inward'=>'Card Inward','self inward'=>'Self Inward'
            $this->form->addField('hidden','hosteler_id');
            $drp_prps = $this->form->addField('dropdown', 'purpose','Action')->setEmptyText('----')->setNotNull();
            $drp_prps->setValueList($array);
			$this->form->addField('line','remarks');
            $sel = $this->form->addField('line', 'sel');
            $sel->js(true)->closest('.atk-form-row')->hide();
			$this->form->addSubmit('Save');
			$this->form->onSubmit(function($form){
				$hm=$form->add('Model_Hosteler');
				$hm->load($form->get('hosteler_id'));
				if($hm['attendence_status'] == $form->get('purpose') AND $form->get('purpose') != 'enquiry'){
					throw $form->exception("Already ". $form->get('purpose'))->setField('purpose');
				}

				$guardians=json_decode($form->get('sel'));

				$sm=$form->add('Model_Students_Movement');
				$sm['student_id']=$hm->id;
				$sm['gaurdian_id'] = $guardians[0];
				$sm['purpose']=$form->get('purpose');
				if($form->get('purpose')=='enquiry' AND trim($form->get('remarks'))=="")
					throw $form->exception("Remark is must for enquiry")->setField('remarks');
				$sm->save();

				$form->js()->univ()->successMessage("Student ID" . $form->get('hosteler_id'))->execute();
			});

		
	}

	function setModel($m){
		if(!($m instanceof Model_Hosteler)) throw $this->exception('Model can be only Hosteler');
		parent::setModel($m);
		$this->information_grid->setModel($m,array('name','room_no','building_name','attendence_status'));
		$m->tryLoadAny();
		if(!$m->loaded()) {
			$this->gaurdian_grid->destroy();
			$this->information_grid->destroy();
			$this->form->destroy();
			return;
		}
		$this->hosteler= $m;

		$this->gaurdian_grid->setModel($m->ref('scholar_id')->ref('Scholars_Guardian'),array('gname','address','image_url'));
		$this->form->getElement('hosteler_id')->set($m->id);
            

            // $map = $this->add('Model_Scholars_Guardian');

		$sel = $this->form->getElement('sel');
            $this->gaurdian_grid->addSelectable($sel);
   //          if($this->form->isSubmitted()){
			// 	$this->form->js()->univ()->successMessage("Student ID" . $this->form->get('hosteler_id'))->execute();
			// 	// $this->handelForm($this->form);
			// }
	}

	function render(){
		
		parent::render();
	}

	function handelForm(&$form){
		$form->js()->univ()->successMessage("Student ID" . $form->get('hosteler_id'))->execute();
	}

}