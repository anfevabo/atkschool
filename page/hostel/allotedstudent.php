<?php

class page_hostel_allotedstudent extends Page{
	function init(){
		parent::init();

		$c=$this->add('Model_Class');
		$form=$this->add('Form');
		$form->addField('dropdown','class')->setModel($c);
		$form->addSubmit("Get List");

		$h=$this->add('Model_Hosteler');
		if($_GET['filter']){
			$h->addCondition('class_id',$_GET['class']);
		}else{
			// $c->tryLoadAny();
		}
		$grid=$this->add('Grid');
		$grid->setModel($h,array('scholar','class','building_name','room_no'));
		$grid->addFormatter('scholar','hindi');
		if($form->isSubmitted()){
			$grid->js()->reload(array(
								"class"=>$form->get('class'),
								"filter"=>-1
								)
							)->execute();
		}
	}
}
