<?php

class Model_Class extends Model_Table{

	var $table="class_master";

	function init(){
		parent::init();

		$this->addField('class_name', 'name')->mandatory("Please give a class name")->caption('Class Name');
        $this->addField('section')->mandatory('give a class name')->display(array('grid'=>'hindi','form'=>'Hindi'));
        $this->addExpression('name')->set('(concat(name," - ",section))');
        $this->hasMany('Student','class_id');
        $this->hasMany('RelatedSubject','class_id');
	}

}