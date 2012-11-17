<?php

class Model_Bill extends Model_Table{
	var $table="bill_master";

	function init(){
		parent::init();

		$this->hasOne('Party','party_id');
		$this->addField('name');
		$this->addField('bill_date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('item_date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('paid')->type('boolean')->defaultValue(false);
	}
}