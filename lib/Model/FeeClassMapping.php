<?php

class Model_FeeClassMapping extends Mode_Table{
	var $table="fee_class_mapping";

	function init(){
		parent::init();
		$this->hasOne('Fee','fee_id');
		$this->hasOne('Class','class_id');
		$this->hasOne('Session','session_id');
	}
}