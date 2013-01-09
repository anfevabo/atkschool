<?php
class Model_Disease_Remarks extends Model_Table{
	var $table="diseases_remarks";
	function init(){
		parent::init();

		$this->addField('remarks')->type('text')->mandatory('It is Must');
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

	}
}