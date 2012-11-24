<?php
class Model_ExamClassSubjectMapAll extends Model_Table {
	var $table= "examsub_map";
	function init(){
		parent::init();
		$this->hasOne('ExamClassMap','exammap_id');
		$this->hasOne('Subject','subject_id');
		$this->hasOne('Session','session_id');

		$this->addField('min_marks');
		$this->addField('max_marks');

	}
}