<?php

class page_masters_hostel extends Page{
	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('Hostel');
		if($crud->grid)
			 $crud->grid->addColumn('expander','room','Add Rooms');
		
	}

	function page_room(){

		$this->api->stickyGET('hostel_master_id');
		
		$hostel=$this->add('Model_Hostel');
		$hostel->load($_GET['hostel_master_id']);

        $g=$this->add('CRUD')->addStyle('background','#ddd');
        $g->setModel($hostel->ref('HostelRoom'),array('room_no','capacity','alloted','vacant'));

	}
}