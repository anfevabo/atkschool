<?php
class View_StudentMovement extends View{
	var $information_grid;
	var $form;
	var $gaurdian_grid;
	function init(){
		parent::init();
		$this->information_grid = $this->add('Grid');
		$this->guardian_grid = $this->add('Grid');
	}

	function setModel($m){
		if(!($m instanceof Model_Hosteler)) throw $this->exception('Model can be only Hosteler');
		parent::setModel($m);
		// echo $m->get('id');
		// $m->debug();
		$this->information_grid->setModel($m,array('name','room_no','building_name'));
		$m->tryLoadAny();
		$this->guardian_grid->setModel($m->ref('scholar_id')->ref('Scholars_Guardian'),array('gname','address','image'));
	}

}