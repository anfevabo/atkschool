<?php

class Model_SubjectClassMapAll extends Model_Table{
	var $table="subject_class_map";
	function init(){
		parent::init();

		$this->hasOne('Class','class_id');
		$this->hasOne('Subject','subject_id');
		$this->hasOne('Session','session_id');

	}
}