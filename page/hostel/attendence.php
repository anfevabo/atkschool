<?php

class page_hostel_attendence extends Page{
	function page_index(){
		// parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('./roomvise','Rooms Attendance');
		$tabs->addTabURL('./classvise','Class Attendance');
		$tabs->addTabURL('./hostelvise','Hostel Attendance');
		
	}

	function page_roomvise(){
		$grid=$this->add('Grid');

		$session=$this->add('Model_Sessions_Current')->tryLoadAny()->get('id');
		
		$q="
			SELECT 
			hm.building_name building_name,
			rm.room_no room_no,
			sum(s.is_present) attendance
			FROM
				hostel_allotement rmalot
				join student s on s.id=rmalot.student_id
				join rooms rm on rmalot.room_id=rm.id
				join hostel_master hm on hm.id=rm.hostel_id
			WHERE
				rmalot.session_id=$session
			GROUP BY building_name, room_no
		";
		$q=$this->api->db->dsql()->expr($q);

		$grid->setSource($q);
		$grid->addColumn('text','building_name');
		$grid->addColumn('text','room_no');
		$grid->addColumn('text','attendance');
	}

	function page_classvise(){
		$grid=$this->add('Grid');

		$session=$this->add('Model_Sessions_Current')->tryLoadAny()->get('id');
		
		$q="
			SELECT 
			concat(c.name,' ',c.section) class,
			sum(s.is_present) attendance
			FROM
				hostel_allotement rmalot
				join student s on s.id=rmalot.student_id
				join class_master c on s.class_id=c.id
			WHERE
				rmalot.session_id=$session
			GROUP BY s.class_id
		";
		$q=$this->api->db->dsql()->expr($q);

		$grid->setSource($q);
		$grid->addColumn('text','class');
		$grid->addColumn('text','attendance');

		$grid->addFormatter('class','hindi');
	}

	function page_hostelvise(){
		$grid=$this->add('Grid');

		$session=$this->add('Model_Sessions_Current')->tryLoadAny()->get('id');
		
		$q="
			SELECT 
			hm.building_name building_name,
			sum(s.is_present) attendance
			FROM
				hostel_allotement rmalot
				join student s on s.id=rmalot.student_id
				join rooms rm on rmalot.room_id=rm.id
				join hostel_master hm on hm.id=rm.hostel_id
			WHERE
				rmalot.session_id=$session
			GROUP BY building_name
		";
		$q=$this->api->db->dsql()->expr($q);

		$grid->setSource($q);
		$grid->addColumn('text','building_name');
		$grid->addColumn('text','attendance');

	}
}