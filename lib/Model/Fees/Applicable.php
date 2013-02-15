<?php

class Model_Fees_Applicable extends Model_Table{
	var $table="fee_applicable";
	function init(){
		parent::init();

		$this->hasOne('Student','student_id');
		$this->hasOne('FeeClassMapping','fee_class_mapping_id')->caption('Fee Applicable');
		// $this->hasOne('Fee','fee_id');
		$this->addField('amount');
		$this->addField('due')->defaultValue(0);


		$this->hasMany('Fees_Deposit','fee_applicable_id');

		$this->addExpression('paid')->set(function ($m,$q){
					return $m->refSQL('Fees_Deposit')->dsql()->del('field')->field('sum(paid)');
		});
		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		if(!$this->loaded()){
			$this['due'] = $this['amount'];
		}

		if($this['amount']<$this['due']) throw $this->exception("Due Amount can not be greater then Total Amount ");
	}

	function submitFee($amount,$onDate,$receiptNo){
		
	}
}