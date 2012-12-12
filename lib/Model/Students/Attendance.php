<?php
class Model_Students_Attendance extends Model_Table{
	var $table="student_attendance";
	function init(){
		parent::init();

		$this->hasOne('Class','class_id');
		$this->hasOne('Student','student_id');
		$this->hasOne('Session','session_id');

		$this->addField('month');
		$this->addField('total_attendance');
		$this->addField('present');

		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		if($this['present'] > $this['total_attendance'])
			$this->owner->js()->univ()->errorMessage("Present can not be greater then Total Attendance")->execute();
	}
}