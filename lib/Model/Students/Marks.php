<?php
class Model_Students_Marks extends Model_Table{
	var $table="student_marks";
	function init(){
		parent::init();

		$this->hasOne('Student','student_id');
		$this->hasOne('ExamClassSubjectMap','examsub_map_id');
		$this->addField('marks');
		$this->addHook('beforeSave',$this);
	}
		function beforeSave(){
			
			if($this['marks'] > $this->ref('examsub_map_id')->get('max_marks'))		
				 $this->owner->js()->univ()->errorMessage('Marks can not be greater then Max Marks')->execute();
		}
}