<?php
class page_student_marks extends Page{
	function page_index(){
		// parent::init();

		$form=$this->add('Form',null,null,array('form_horizontal'));
		$class_field=$form->addField('dropdown','class')->setEmptyText('----')->setAttr('class','hindi');
		$class_field->setModel('Class');

		$ecm=$this->add('Model_ExamClassMap');
		$ecm->addExpression('name')->set(function($m,$q){
			return $m->refSQL('exam_id')->fieldQuery('name');
		});


		if($_GET['class_filter']){
			$ecm->addCondition('class_id',$_GET['class_filter']);
		}

		$exam_field=$form->addField('dropdown','exam')->setEmptyText('----')->setAttr('class','hindi');

		$exam_field->setModel($ecm);


		$class_field->js('change',$form->js()->atk4_form('reloadField','exam',array($this->api->url(),'class_filter'=>$class_field->js()->val())));

		$sub_field=$form->addField('dropdown','subject')->setEmptyText('----')->setAttr('class','hindi');

		$ecsm=$this->add('Model_ExamClassSubjectMap');

		$ecsm->addExpression('name')->set(function($m,$q){
				return $m->refSQL('subject_id')->fieldQuery('name');
		});
		if($_GET['exam_filter']){
			$ecsm->addCondition('exammap_id',$_GET['exam_filter']);
		}


		$sub_field->setModel($ecsm);

		$exam_field->js('change',$form->js()->atk4_form('reloadField','subject',array($this->api->url(),'exam_filter'=>$exam_field->js()->val())));
		
		$form->addSubmit('GetList');

		// removed from here
		if($form->isSubmitted()){
			$form->js()->univ()->newWindow($this->api->url("./marksinput",array('class'=>$form->get('class'),'subject'=>$form->get('subject'))),null,'height=689,width=1246,scrollbar=1')->execute();
		}
	}

	function page_marksinput(){

		$this->api->stickyGET('class');
		$this->api->stickyGET('subject');

		$grid=$this->add('Grid');
		$sm=$this->add('Model_Students_Marks');
		// $sm->table_alias='sm1';
		$smj=$sm->leftJoin('student.id','student_id',null,'sm2');
		$smj->addField('class_id');
		$smj->addField('roll_no');
		// $sm->debug();

		if($_GET['class']) $sm->addCondition('class_id',$_GET['class']);
		if($_GET['subject']) $sm->addCondition('examsub_map_id',$_GET['subject']);
		
		if($sm->count()->getOne() == 0) {
			$sm_new=$this->add('Model_Students_Marks');
			$cm=$this->add('Model_Class');
			$cm->load($_GET['class']);
			$s=$cm->ref('Students_Current');
			foreach ($s as $junk) {
				// $sm_new->unload();
				$sm_new['student_id']=$s->id;
				$sm_new['examsub_map_id']=$_GET['subject'];
				$sm_new->saveAndUnload();
			}

		}
		// else{
		// 	$sm->addCondition('class',-1);
		// }


		$grid->setModel($sm,array('roll_no','class','student','marks'));
		$grid->addFormatter('student','hindi');
		$grid->addFormatter('marks','grid/inline');
	}
}