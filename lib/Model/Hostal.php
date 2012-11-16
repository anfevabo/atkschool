<?php

class Model_Hostal extends Model_Table{
	var $table="hostal_master";

	function init(){
		parent::init();

		$this->addField('name','building_name');
	}
}