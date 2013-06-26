<?php

class Model_Class extends Model_Table{

	var $table="class_master";

	function init(){
		parent::init();

		$this->addField('class_name', 'name')->mandatory("Please give a class name")->caption('Class Name')->display('hindi');
        $this->addField('section')->mandatory('Give section a name')->display(array('form'=>'hindi','grid'=>'hindi'));
        $this->hasMany('Students_Current','class_id');
        // $this->hasMany('RelatedSubject','class_id');
        $this->hasMany('SubjectClassMap','class_id');
        $this->hasMany('ExamClassMap','class_id');
        $this->hasMany('FeeClassMap','class_id');
        $this->hasMany('Students_Attendance','class_id');
        $this->hasMany('FeeClassMapping','class_id');
		$this->hasMany('MS_Designer','class_id');
        $this->addExpression('name')->set('(concat(name," - ",section))')->display('hindi');
        $this->addExpression('no_of_students')->set(function($m,$q){
            return $m->refSQL('Students_Current')->count();
        });

        $this->addExpression('no_of_subjects')->set(function($m,$q){
            return $m->refSQL('SubjectClassMap')->count();
        });
        
        $this->_dsql()->order($this->getField('id'),'asc');
        $this->addHook('beforeSave',$this);
        $this->addHook('beforeDelete',$this);
	}

    function beforeSave(){
         $this->add('Controller_Unique',array('unique_fields'=>
                            array(
                                array('class_name'=>$this['class_name'],'section'=>$this['section'])
                                )
                            )
                    );
    }

    function beforeDelete(){
        $subject_class_map= $this->add('Model_SubjectClassMapAll');
        $subject_class_map->addCondition('class_id',$this->id);
        if($subject_class_map->count()->getOne() > 0)
            throw $this->exception("This Class has Associated Subjects in any of Session, Kindly remove all subjects from all sessions and try again letter") ;

        $student=$this->add('Model_Student');
        $student->addCondition('class_id',$this->id);
            if($student->count()->getOne()>0)
            throw $this->exception("This Class has Associated Students in any of Session, Kindly remove all Students from all sessions and try again letter") ;
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