<?php

class Model_FeesHead extends Model_Table{
	var $table="fee_heads";
	function init(){
		parent::init();

		$this->addField('name');
		$this->hasMany('FeesHead','feeshead_id');
	}
}