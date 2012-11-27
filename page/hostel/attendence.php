<?php

class page_hostel_attendence extends Page{
	function page_index(){
		// parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('./roomvise','Rooms Attendance');
		// $tabs->addTabURL('./classvise','Class Attendance');
		$tabs->addTabURL('./hostelvise','Hostel Attendance');
		
	}

	function page_roomvise(){
		$grid=$this->add('Grid');
		$h=$this->add('Model_HostelRoom');
		$grid->setModel($h,array('hostel','room_no','in_count'));
		$grid->addPaginator();
	}

	function page_classvise(){

	}

	function page_hostelvise(){

		$h=$this->add('Model_Hostel');
		$h->getElement("alloted")->caption("Total Students");
		$h->addExpression("total_present")->set(function ($m,$q){
					return $m->refSQL('HostelRoom')->sum("in_count");
		});

		$grid=$this->add('Grid');
		$grid->setModel($h,array("name","rooms","alloted","total_present"));

	}
}