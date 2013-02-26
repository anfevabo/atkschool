<?php
class Model_ExamClassSubjectMapAll extends Model_Table {
	var $table= "examsub_map";
	function init(){
		parent::init();
		$this->hasOne('ExamClassMap','exammap_id');
		$this->hasOne('Subject','subject_id');
		$this->hasOne('Session','session_id');

		$this->addField('min_marks')->display(array('grid'=>'grid/inline'));
		$this->addField('max_marks')->display(array('grid'=>'grid/inline'));
		$this->addField('in_ms_row')->caption('Marksheet Row')->display(array('grid'=>'grid/inline'));

		$this->hasOne('MS_Sections','marksheet_section_id')->caption('Marksheet Section')->display(array('grid'=>'grid/inline'));
		$this->hasMany('Marks','examsub_map_id');

	}
}