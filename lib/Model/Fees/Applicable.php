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

		$this->addExpression('feehead_id')->set(function($m,$q){
			return $m->refSQL('fee_class_mapping_id')->fieldQuery('feehead_id');
		});
		
		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		if(!$this->loaded()){
			$this['due'] = $this['amount'];
		}else{
			$amount_deposited_till_now = $this->ref('Fees_Deposit')->sum('paid')->getOne();
			if($this['amount'] < $amount_deposited_till_now) throw $this->exception("Due Amount can not be greater then Total Amount ");
			$this['due'] = $this['amount'] - $amount_deposited_till_now;
		}

	}

	function submitFee($amount,$onDate,$receiptNo){
		
	}
}