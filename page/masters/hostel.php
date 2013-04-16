<?php

class page_masters_hostel extends Page{
	function page_index(){
		$acl=$this->add('xavoc_acl/Acl');
		$crud=$this->add('CRUD',$acl->getPermissions());
		$h=$this->add('Model_Hostel');
		$crud->setModel($h);
		if($crud->grid){
			 $crud->grid->addColumn('expander','room','Add Rooms');
			 $crud->grid->setFormatter('capacity','number');
			 $crud->grid->setFormatter('alloted','number');
			 $crud->grid->setFormatter('vacant','number');
			 $crud->grid->setFormatter('Rooms','number');
			 $crud->grid->setFormatter('vacant','diff');
			 $crud->grid->addFormatter('vacant','number');
			 $crud->grid->addTotals(array('Rooms','capacity','alloted','vacant'));
			 // $h->_dsql()->order('Rooms','asc');
			}
		
	}

	function page_room(){

		$this->api->stickyGET('hostel_master_id');
		
		$hostel=$this->add('Model_Hostel');
		$hostel->load($_GET['hostel_master_id']);

        $g=$this->add('CRUD')->addStyle('background','#ddd');
        $g->setModel($hostel->ref('HostelRoom'),array('room_no','capacity','alloted','vacant'));
        $hostel->_dsql()->order('room_no','asc');
	}
}