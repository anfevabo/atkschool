<?php
class Model_Fee extends Model_Table{
	var $table="fee";
	function init(){
	
		parent::init();

		$this->hasOne('FeesHead','feeshead_id');
		$this->addField('name');
		$this->addField('isOptional')->type('boolean');
		$this->addField('scholaredamount');

		$this->hasMany('Fees_Applicable','fee_id');
		$this->hasMany('Fees_Deposit','fee_id');
		$this->hasMany('FeeClassMapping','fee_id');
	}
}