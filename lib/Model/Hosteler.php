<?php

class Model_Hosteler extends Model_Student{

	function init(){
		parent::init();
		$this->addCondition('ishostler',true);
		$raj=$this->join('hostel_allotement.student_id','id');
		$rj=$raj->join('rooms.id','room_id');
		$bj=$rj->join('hostel_master.id','hostel_id');
		$rj->addField('room_no');
		$bj->addField('building_name');
	}
}