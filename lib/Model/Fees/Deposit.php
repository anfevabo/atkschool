<?php

class Model_Fees_Deposit extends Model_Table{
	var $table="fee_deposit_master";
	function init(){
		parent::init();

		$this->hasOne('Fee','fee_id');
		$this->addField('due');
		$this->addField('paid');
		$this->addField('due_date')->type('date');
		$this->addField('deposit_date')->type('date')->defaultValue(date('Y-m-d'));
	}
}