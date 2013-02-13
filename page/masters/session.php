<?php

class page_masters_session extends Page{

	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');

		$crud=$this->add('CRUD',array('allow_del'=>false));
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

		$crud->setModel('Session',array('name','start_date','end_date'),array('name','iscurrent','start_date','end_date'));
		if($crud->grid){
			$crud->grid->addColumn('Button','mark_current');
		}

		// print_r($acl->getPermissions());

	}	

}