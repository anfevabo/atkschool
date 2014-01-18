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
		// $this->addField('in_ms_row')->caption('Marksheet Row')->display(array('grid'=>'grid/inline'));

		// $this->hasOne('MS_Sections','marksheet_section_id')->caption('Marksheet Section')->display(array('grid'=>'grid/inline'));
		$this->hasMany('Marks','examsub_map_id');

	}

	function promote($from_session, $to_session){

		$old_mapping = $this->add('Model_ExamClassSubjectMapAll');
		$old_mapping->addCondition('session_id',$from_session);

		foreach($old_mapping as $old){
			$new=$this->add('Model_ExamClassSubjectMapAll');
			
			$old_exammap= $this->add('Model_ExamClassMapAll')->load($old['exammap_id']);

			$new_exammap = $this->add('Model_ExamClassMapAll');
			$new_exammap->addCondition('exam_id',$old_exammap['exam_id']);
			$new_exammap->addCondition('class_id',$old_exammap['class_id']);
			$new_exammap->addCondition('session_id',$to_session);
			$new_exammap->loadAny();

			$new['exammap_id'] = $new_exammap->id;
			$new['subject_id']= $old['subject_id'];
			$new['session_id'] = $to_session;

			$new->save();
			
			$new->destroy();
			$old_exammap->destroy();
			$new_exammap->destroy();

		}


	}
}