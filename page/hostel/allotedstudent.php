<?php

class page_hostel_allotedstudent extends Page{
	function init(){
		parent::init();

		$c=$this->add('Model_Class');
		$form=$this->add('Form');
		$class_field=$form->addField('dropdown','class')->setEmptyText('-----')->setAttr('class','hindi');
		$class_field->setModel($c);
		$form->addSubmit("Get List");

		$h=$this->add('Model_Hosteler');
		$h->_dsql()->del('order')->order('building_name','asc')->order('room_no','asc');
		// $h->_dsql()->order('scholar','asc');
		if($_GET['filter']){
			$h->addCondition('class_id',$_GET['class']);
		}else{
			$h->addCondition('class_id',-1);
		}
		$grid=$this->add('Grid');
		$grid->addColumn('sno','sno');
		$grid->setModel($h,array('sno','name','class','building_name','room_no'));

		// $grid->addFormatter('scholar','hindi');
		$grid->addFormatter('class','hindi');
		if($form->isSubmitted()){
			$grid->js()->reload(array(
								"class"=>$form->get('class'),
								"filter"=>-1
								)
							)->execute();
		}
	}
}
