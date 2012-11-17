<?php

class Model_RoomAllotement extends Model_Table{
	var $table="hostel_allotement";

	function init(){
		parent::init();

		$this->hasOne('Student','student_id');
		$this->hasOne('HostelRoom','room_id');
		$this->hasOne('Session','session_id');

		$
	}
}