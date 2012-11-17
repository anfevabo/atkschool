<?php

class Model_Item_Inward extends Model_Table{
	var $table="item_inward";

	function init(){
		parent::init();

		$this->hasOne('Item','item_id');
		$this->hasOne('Bill','bill_id');
	}
}