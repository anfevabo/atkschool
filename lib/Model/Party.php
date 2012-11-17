<?php

class Model_Party extends Model_Table{
	var $table="party_master";
	function init(){
		parent::init();

		$this->addField('ename');
		$this->addField('name')->display('hindi');
		$this->addField('contact');
		$this->addField('address')->display('hindi');

		$this->hasMany('Bill','party_id');

	}
}