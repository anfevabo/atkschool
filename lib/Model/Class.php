<?php

class Model_Class extends Model_Table{

	var $table="class_master";

	function init(){
		parent::init();

		$this->addField('class_name', 'name')->mandatory("Please give a class name")->caption('Class Name');
        $this->addField('section')->mandatory('give a class name')->display('hindi');
        $this->hasMany('Student','class_id');
        $this->hasMany('RelatedSubject','class_id');
        $this->hasmany('SubjectClassMap','class_id');
        $this->addExpression('name')->set('(concat(name," - ",section))')->display('hindi');
	}

	function setSubjects($ids)
    {
        if($ids==null)return;
        $ss=$this->add('Model_Sessions_Current')->loadAny();
    	foreach($ids as $id){
    		$res[]=array('subject_id'=>$id, 'class_id'=>$this->id, 'session_id'=>$ss->id);
    	}
    	$this->ref('SubjectClassMap')->dsql()->insertAll($res);
    }

}