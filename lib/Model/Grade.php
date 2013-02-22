<?php
class Model_Grade extends Model_Table{
	var $table = "grade_master";
	
	function init(){
		parent::init();

		$this->addField("name")->caption("Grade");
		$this->addField("percentage");
		$this->hasOne("Session","session_id");
		$this->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));


	}
}