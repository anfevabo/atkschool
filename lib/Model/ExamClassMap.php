<?php

class Model_ExamClassMap extends Model_Table {
	var $table= "exam_map";
	function init(){
		parent::init();
		$this->hasOne('Exam','exam_id')->display('hindi');
		$this->hasOne('Class','class_id');
		$this->hasOne('Sessions_Current','session_id');

		$this->hasMany('ExamClassSubjectMap','exammap_id');
	}
}