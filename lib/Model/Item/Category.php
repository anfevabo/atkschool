<?php

class Model_Item_Category extends Model_Table{
	var $table="item_category";
	function init(){
		parent::init();

		$this->hasMany('Item','category_id');
		$this->addField('name')->caption('Category');
	}
}