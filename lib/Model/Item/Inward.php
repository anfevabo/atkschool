<?php

class Model_Item_Inward extends Model_Table{
	var $table="item_inward";

	function init(){
		parent::init();

		$this->hasOne('Item','item_id');
		$this->hasOne('Bill','bill_id');
		$this->hasOne('Session','session_id');
		$this->addField('quantity');
		$this->addfield('rate');
		$this->addfield('date')->type('date')->defaultValue(date('Y-m-d'));
	}
}