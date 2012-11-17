<?php

class Model_HostelRoom extends Model_Table{
	var $table="rooms";

	function init(){

		parent::init();

		$this->hasOne('Hostel','hostel_id');
		$this->addField('room_no');
		$this->addField('capacity');
	
		$this->hasMany('HostelRoom','room_id');
		$this->hasMany('RoomAllotement','room_id');

		$this->addExpression('alloted')->set(function ($m,$q){
			return $m->refSQL('RoomAllotement')->count();
		});
	}
}