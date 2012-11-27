<?php
class page_student_report extends Page{
	function init(){
		parent::init();
		$form=$this->add('Form',null,null,array('form_empty'));
		$class=$form->addField('dropdown','class')->setEmptyText('----')->setAttr('class','hindi');
		$c=$this->add('Model_Class');
		$class->setModel($c);
		$s=$form->addField('dropdown','sex')->setValueList(array("-1"=>"Any",
																"M"=>"Male",
																"F"=>"Female"))->set('-1');
		$cat=$form->addField('dropdown','category')->setValueList(array("-1"=>'Select Category', 
																		'GEN'=>'GEN',
																		"ST"=>"ST",
																		"SC"=>"SC",
																		"TAD"=>"TAD(ST)",
																		"OBC"=>"OBC",
																		"SOBC"=>"SPECIAL OBC",
																		"MINORITY"=>"MINORITY"))->set('-1');
	
		$h=$form->addField('dropdown','hostel')->setValueList(array("-1"=>"Any",
																	"0"=>"Local",
																	"1"=>"Hosteler"))->set('-1');																
		$b=$form->addField('dropdown','bpl')->setValueList(array("-1"=>"Any",
																	"0"=>"No",
																	"1"=>"Yes"))->set('-1');																
		$sc=$form->addField('dropdown','scholar')->setValueList(array("-1"=>"Any",
																	"0"=>"Private",
																	"1"=>"Scholared"))->set('-1');																
		$from_age=$form->addField('line','from_age ')->js(true)->univ()->numericField();

        $to_age=$form->addField('line',' to_age ')->js(true)->univ()->numericField();
        $form->addSubmit('Print');


      if($form->isSubmitted())
      {
       $this->js()->univ()->newWindow($this->api->url("student/studentlist",array("class"=>$form->get('class'),"sex"=>$form->get('sex'),"category"=>$form->get('category'),"hostel"=>$form->get('hostel'),"scholar"=>$form->get('scholar'),"bpl"=>$form->get('bpl'),"to_age"=>$form->get('to_age'),"from_age"=>$form->get('from_age'))),null,'height=689,width=1246,scrollbar=1')->execute();
      }
      
	}
}