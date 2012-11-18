<?php
class Model_ExamClassSubjectMap extends Model_Table {
	var $table= "examsub_map";
	function init(){
		parent::init();
		$this->hasOne('ExamClassMap','exammap_id');
		$this->hasOne('Subject','subject_id');
		$this->hasOne('Sessions_Current');

		$this->addField('min_marks');
		$this->addField('max_marks');

	}
}