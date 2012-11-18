<?php

class Model_RoomAllotement extends Model_Table{
	var $table="hostel_allotement";

	function init(){
		parent::init();

		$this->hasOne('Student','student_id');
		$this->hasOne('HostelRoom','room_id');
		$this->hasOne('Session','session_id');

		$this->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
		$this->addHook('beforeSave',$this);
	}
	function beforeSave(){

		$tmp=$this->add('Model_RoomAllotement');

		$tmp->addCondition('student_id',$this['student_id']);
		$tmp->addCondition('session_id',$this['session_id']);

		$tmp->tryLoadAny();

		if($tmp->loaded()){

			throw $this->exception("This student has allready a Room Alloted");
			// ->setField('room_no');

		}
	}
}