<?php

class Model_Item extends Model_table{
	var $table="item_master";

	function init(){
		parent::init();

		$this->hasOne('Item_Category','category_id');
		$this->addField('name')->caption('Item');
	}
}