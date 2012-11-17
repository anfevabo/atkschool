<?php

class Model_Exam  extends Model_Table
{
    
    var $table='exam_master';
    function init()
    {
        parent::init();
        $this->addField('name')->display(array('form'=>'hindi','grid'=>'hindi'));
        // $this->hasMany("ExamMap","exam_id");
    }
}