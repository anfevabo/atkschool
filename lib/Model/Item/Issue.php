<?php

class Model_Item_Issue extends Model_Table{
	var $table="item_issue";

	function init(){
		parent::init();

		$this->hasOne('Hosteler','student_id');
		$this->hasOne('Item','item_id');
		$this->hasOne('Session','session_id');

		$this->addField('quantity');
		$this->addField('rate');
		$this->addField('date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addExpression('amount')->set('quantity * rate');

	}
}