<?php
class View_StudentMovement extends View{
	var $information_grid;
	var $form;
	var $gaurdian_grid;
	function init(){
		parent::init();
		$this->information_grid=$this->add('Grid');
		$this->gaurdian_grid=$this->add('Grid');
		$this->form = $this->add('Form',NULL,NULL,array('form_horizontal'));
		
	}

	function setModel($m){
		if(!($m instanceof Model_Hosteler)) throw $this->exception('Model can be only Hosteler');
		parent::setModel($m);
		echo $m->get('id');
		$this->information_grid->setModel($m,array('name','room_no','building_name','attendence_status','scholar'));
		$m->tryLoadAny();
		$this->gaurdian_grid->setModel($m->ref('scholar_id')->ref('Scholars_Guardian'),array('gname','address','image'));
		
            $array = array('inward' => 'inward', 'outward' => 'outward', 'enquiry' => 'enquiry');//, 'card outward'=>'Card Outward','self outward'=>'Self Outward','card inward'=>'Card Inward','self inward'=>'Self Inward'
            $drp_prps = $this->form->addField('dropdown', 'purpose','Action');
            $drp_prps->setValueList($array);
			$this->form->addField('line','remarks');
            $sel = $this->form->addField('line', 'sel');
            // $sel->js(true)->closest('.atk-form-row')->hide();
			$this->form->addSubmit('Save');

            $map = $this->add('Model_Scholars_Guardian');


            $this->gaurdian_grid->addSelectable($sel);
	}

	function render(){
		if($this->form->isSubmitted()){
				$this->handelForm($this->form);
			}
		parent::render();
	}

	function handelForm($form){
		
	}

}