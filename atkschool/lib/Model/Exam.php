<?php

class Model_Exam  extends Model_Table
{
    
    var $table='exam_master';
    function init()
    {
        parent::init();
        $this->addField('name')->display('hindi');
        $this->hasMany("ExamClassMap","exam_id");

        $this->addHook('beforeDelete',$this);
    }

    function beforeDelete(){
    	if($this->ref('ExamClassMap')->count()->getOne())
    		throw $this->exception('This Exam has Associated Classes, remove them first to remove this Exam');
    }
}