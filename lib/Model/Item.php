<?php

class Model_Item extends Model_Table{
	var $table="item_master";

	function init(){
		parent::init();

		$this->hasOne('Item_Category','category_id')->display(array('grid'=>'hindi'))->mandatory("Select Category First");
		$this->addField('name')->caption('Item')->display('hindi');
		$this->hasMany('Item_Inward','item_id');
		$this->hasMany('Item_Issue','item_id');

		$this->addExpression("LastPurchasePrice")->set(function ($m,$q){
			return $m->refSQL('Item_Inward')->dsql()->del('field')->field('rate')->limit(1)->order('id','desc');
		});

		$this->addExpression("TotalInward")->set(function ($m,$q){
				return $m->refSQL("Item_Inward")->sum('quantity');
		});

		$this->addExpression("TotalIssued")->set(function ($m,$q){
				return $m->refSQL("Item_Issue")->sum('quantity');
		});

		$this->addExpression("instock")->set('id')->display(array("grid"=>'instock'));
	}
}