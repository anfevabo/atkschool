<?php

class Model_Staff_Movement extends Model_Table {
	var $table= "staff_outward";
	function init(){
		parent::init();
		$this->hasOne('Staff','staff_id');
		$this->addField('date')->type('date')->defaultValue(date('Y-m-d H:i:s'))->display(array('grid'=>'datetime'));
		$this->addField('action')->enum(array('inward','outward'))->display(array('grid'=>'attendance'));
	}
}