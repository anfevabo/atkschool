<?php

class Model_Subject extends Model_Table{

    var $table = 'subject_master';

    function init() 
    {
    
        parent::init();
        $this->addField('name')->mandatory('subject can not be blank')->display('hindi');
        $this->addField('code');
       // $this->addField('max_marks')->type('int');
       //$this->addField('pass_marks')->type('int');

        $this->hasMany('RelatedClass','subject_id');
        $this->hasMany('ExamClassSubjectMap','subject_id');
        

    }

}