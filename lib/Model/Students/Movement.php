<?php
class Model_Students_Movement extends Model_Table{
	var $table="hosteller_outward";
	function init(){
		parent::init();

		$this->hasOne('Scholar','scholar_id');
		$this->hasOne('Scholars_Guardian','gaurdian_id');
		$this->addField('date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('purpose');
		$this->addField('remark');
	}
}