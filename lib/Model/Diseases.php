<?php
class Model_Diseases extends Model_Table{
	var $table="diseases";
	function init(){
		parent::init();
		$this->addField('name')->display('hindi');
	}
}