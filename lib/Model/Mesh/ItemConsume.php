<?php

class Model_Mesh_ItemConsume extends Model_Table{
	var $table="mesh_item_consume";

	function init(){
		parent::init();
		

		$this->hasOne('Mesh_Item','item_id');
		$this->hasOne('Party','party_id');
		$this->hasOne('Session','session_id');

		$this->addField('quantity')->mandatory('quantity is Must To Select');
		$this->addField('unit')->enum(array('Packet','Kg','Liter'))->mandatory('quantity is Must To Select');
		$this->addField('date')->type('date')->defaultValue(date('Y-m-d'));
		// $this->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));

		$this->add('dynamic_model/Controller_AutoCreator');
		// $this->addHook('beforeSave',$this);
	}
	// function beforeSave(){
	// 	if(!$this->loaded()){
	// 		// search for existing recipt number for current month
	// 		$temp=$this->add('Model_Item_Issue');
	// 		$temp->addCondition('student_id',$this['student_id']);
	// 		$temp->addCondition('month',date('m',strtotime($this['date'])));
	// 		$temp->addCondition('year',date('Y',strtotime($this['date'])));
	// 		$temp->tryLoadAny();
	// 		// $temp->debug();
	// 		if($temp->loaded()){
	// 			// Keeping single receipt number for a month for any student
	// 			$this['receipt_no']=$temp['receipt_no'];
	// 		}else{
	// 		// get new recipt number
	// 			$temp=$this->add('Model_Item_issue');
			// 			$r=$temp->dsql()->del('field')->field('max(receipt_no)')->where('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'))->getOne();
	// 			$this['receipt_no']=$r+1;

	// 		}
	// 	}
	// }
}