<?php

class Model_Student extends Model_Table{
	var $table="student";

	function init(){
		parent::init();

                $this->hasOne('Scholar','scholar_id');
                $this->hasOne('Class','class_id');
                $this->hasOne('Session','session_id');
		$this->addField('roll_no')->type('int')->caption('roll number');
                $this->addField('ishostler')->type('boolean')->defaultValue(false)->caption("Is Hostler");
                $this->addField('isScholared')->type('boolean');
                $this->addField('Section');
                $this->addField('store_no');
                $this->addField('isalloted')->type('boolean')->defaultValue(false);
                $this->addField('bpl')->type('boolean')->defaultValue(false);

                $this->hasMany('RoomAllotement','student_id');
                $this->hasMany('Item_Issue','student_id');
                $this->hasMany('Students_Disease','student_id');
                $this->hasMany('Students_Movement','student_id');

                $this->addExpression('name')->set(function ($m,$q){
                        return $m->refSQL('scholar_id')->dsql()->del('field')->field('hname');
                })->display('hindi');

	}

}