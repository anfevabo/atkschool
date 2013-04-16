<?php
class Model_Diseases extends Model_Table{
	var $table="diseases";
	function init(){
		parent::init();
		$this->addField('name')->display('hindi')->mandatory("Disease Name is Must");
		$this->hasMany('Diseases','disease_id');
		$this->addHook('beforeDelete',$this);
	}

	function beforeDelete(){
		if($this->ref('Students_Diseases')->count()->getOne())
			throw $this->exception("You can not delete, It contains Student Disease");
	}
}