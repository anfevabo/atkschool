<?php

class page_masters_session extends Page{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		if($_GET['mark_current']){
			$m=$this->add('Model_Session');
			$m->load($_GET['mark_current']);
			if(!$m['iscurrent']) {	
				$m->markCurrent();
				$crud->grid->js(null,$crud->grid->js()->reload())->univ()->successMessage("Session Changed")->execute();
			}
			else
				$crud->grid->js()->univ()->errorMessage("This is Already Current Session")->execute();
			$crud->grid->js()->reload()->execute();
		}

		$crud->setModel('Session',array('name'),array('name','iscurrent'));
		if($crud->grid){
			$crud->grid->addColumn('Button','mark_current');
		}

	}	

}