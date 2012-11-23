<?php
class Model_Students_Disease extends Model_Table{
		var $table="disease_master";
	function init(){
		parent::init();
		$this->hasOne('Student','student_id');
		$this->hasOne('Diseases','disease_id');
		// $this->addField('disease')->display('hindi');
		$this->addField('report_date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('treatment')->type('boolean')->defaultValue(false)->caption('Treatment Completed');
		$this->addField('treatment_date')->type('date');

		// $this->addExpression("name")->set('student_id');
		
	}
}