<?php

class Model_Fees_Applicable extends Model_Table{
	var $table="fee_applicable";
	function init(){
		parent::init();

		$this->hasOne('Student','student_id');
		$this->hasOne('Fee','fee_id');
		$this->addField('amount');
		$this->addField('due');
	}
}