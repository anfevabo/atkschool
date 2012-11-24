<?php

class page_test extends Page {
	function page_index(){
		$m=$this->add('Model_ExamClassMap');
		$m->load(4);

		$ecsm=$m->ref('ExamClassSubjectMap');
		$ecsm->addCondition('subject_id','in',$m->ref('class_id')->ref('SubjectClassMap')->dsql()->del('field')->field('subject_id'));
		// $ecsm->debug();
		$grid=$this->add('Grid');
		$grid->setModel($ecsm);

		$grid->addFormatter('subject','hindi');

	}
}	