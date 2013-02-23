<?php
class page_student_marksheet extends Page{
	function page_index(){
		// parent::init();

		$form=$this->add("Form",null,null,array('form_horizontal'));
		$class_field=$form->addField('dropdown','class')->setEmptyText("----");
		$class_field->setAttr('class','hindi');
		$c=$this->add("Model_Class");

		$student_feild=$form->addField('dropdown','students')->setEmptyText("-----")->setAttr('class','hindi');

		$s=$this->add("Model_Student");

		$form->addSubmit('Save');

		if($_GET['class_id']){
			$s->addCondition('class_id',$_GET['class_id']);
		}

		$class_field->setModel($c);
		$student_feild->setModel($s);

		$class_field->js('change',$form->js()->atk4_form('reloadField','students',array($this->api->url(),'class_id'=>$class_field->js()->val())));

		if($form->isSubmitted()){
			// $form->js()->univ()->successMessage('Hi')->execute();
			$this->js()->univ()->redirect($this->api->url("./marksheets",array('class'=>$form->get('class'),'student'=>$form->get('students'))),null,'height=689,width=1246,scrollbar=1')->execute();
		}
	}

	function page_marksheets(){
		$class = $this->add('Model_Class')->load($_GET['class']);
		$mark_sheet = $class->ref('MarksheetDesigner')->tryLoadAny();

		$main_block_grid = $this->add('Grid');
		$main_block_grid->addColumn('text','Subject');
		$main_block_grid->columns['Subject'];

		foreach($mark_sheet->ref('MainBlock') as $blocks){
			$main_block_grid->addColumn($blocks['name']);
		}

		$main_block_grid->setSource(array());


	}
}