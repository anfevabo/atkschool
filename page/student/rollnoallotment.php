<?php
class page_student_rollnoallotment extends Page{
	function page_index(){

		$form=$this->add('Form',null,null,array('form_horizontal'));
		$class_field=$form->addField('dropdown','class')->setEmptyText('-----');
		$class_field->setModel('Class');
		$class_field->setAttr('class','hindi');
		$roll_field=$form->addField('line','roll_no')->setNotNull();

		$form->addSubmit("Allot");

		$c=$this->add('Model_Students_Current');
		$grid=$this->add('Grid');
		if($_GET['class']){
			$c->addCondition('class_id',$_GET['class']);
		}else{
			$c->addCondition('class_id',-1);
		}

		$grid->setModel($c, array('name','class','roll_no'));
		$grid->addColumn('Expander','edit','Edit');
		
		$grid->addClass('reladable_grid');
		$grid->js('reloadme',$grid->js()->reload());

		if($form->isSubmitted()){

			$students=$this->add('Model_Students_Current');
			$students->addCondition('class_id',$form->get('class'));
			$start_roll_no=$form->get('roll_no');
			foreach ($students as $junk) {
				$students['roll_no'] = $start_roll_no ++;
				$students->save();
			}
			$grid->js(null,$form->js()->reload())->reload(array("class"=>$form->get("class")))->execute();
		}

		$class_field->js('change',$grid->js()->reload(array('class'=>$class_field->js()->val())));


	}

	function page_edit(){
		$this->api->stickyGET('student_id');
		$m=$this->add('Model_Students_Current');
		$m->load($_GET['student_id']);
		$form = $this->add('Form');
		$form->setModel($m,array('roll_no'));
		if($form->isSubmitted()){
			$form->update();
			$form->js()->univ()->successMessage('Upadetd')->closeExpander()->execute();
			// $form->js()->_selector('.reladable_grid')->reload(array('class'=>$m['class_id']))->execute();
		}
	}
}