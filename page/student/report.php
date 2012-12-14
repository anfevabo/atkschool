<?php
class page_student_report extends Page{

	public $field_list=array('sno','roll_no','scholar_no','class','name','father_name','mother_name','admission_date', 'dob','contact','p_address','sex','category');

	function page_index(){

		$acl=$this->add('xavoc_acl/Acl');
		$form=$this->add('Form',null,null,array('form_empty'));
		$class=$form->addField('dropdown','class')->setEmptyText('----')->setAttr('class','hindi');
		$c=$this->add('Model_Class');
		$class->setModel($c);
		$s=$form->addField('dropdown','filter_sex')->setValueList(array("-1"=>"Any",
																"M"=>"Male",
																"F"=>"Female"))->set('-1');
		$cat=$form->addField('dropdown','filter_category')->setValueList(array("-1"=>'Select Category', 
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

        foreach($this->field_list as $f){
        	$form->addField('checkbox',$f);
        }

        $form->addSubmit('Print');


      if($form->isSubmitted())
      {
      	$chk_values=array();
      	foreach($this->field_list as $f){
      		$chk_values += array($f => $form->get($f));
      	}
      	$form_values=array("class"=>$form->get('class'),"filter_sex"=>$form->get('filter_sex'),"filter_category"=>$form->get('filter_category'),"hostel"=>$form->get('hostel'),"scholar"=>$form->get('scholar'),"bpl"=>$form->get('bpl'),"to_age"=>$form->get('to_age'),"from_age"=>$form->get('from_age'));
		$total_values=$form_values + $chk_values;      	
       $this->js()->univ()->newWindow($this->api->url("./studentlist",$total_values),null,'height=689,width=1246,scrollbar=1')->execute();
      }
      
	}


	function page_studentlist(){


        $this->api->stickyGET('class');
        $this->api->stickyGET('sex');
        $this->api->stickyGET('category');
        $this->api->stickyGET('hostel');
        $this->api->stickyGET('scholar');
        $this->api->stickyGET('bpl');
        $this->api->stickyGET('to_age');
        $this->api->stickyGET('from_age');

        $grid=$this->add('Grid');


         $m=$this->add('Model_Scholars_Current');
        
	
        if($_GET["class"]){
        	$m->addCondition('class_id',$_GET['class']);
        }
        if($_GET["filter_sex"]!="-1"){
        	 $m->addCondition('sex',$_GET['filter_sex']);
        }
         if($_GET['filter_category']!="-1")
        {
            if($_GET['filter_category']=='tadst')
            {
                $m->addCondition('category',array('ST','TAD'));
                //$m->addCondition('category','TAD');
            } 
            else
            $m->addCondition('category',$_GET['filter_category']);
        }

        if($_GET['hostel']!="-1")
        {
          $m->addCondition('ishostler',$_GET['hostel']);   
        }
        if($_GET['scholar']!="-1")
        {
            $m->addCondition('isScholared',$_GET['scholar']);
        }
        if($_GET['bpl']!="-1")
        {
            $m->addCondition('bpl',$_GET['bpl']);
        }

        if($_GET['to_age'])
        	$m->addCondition('age','<=',$_GET['to_age']);
        if($_GET['from_age'])
        	$m->addCondition('age','>=',$_GET['from_age']);
        // $m->debug();

        $m->_dsql()->del('order')->order('roll_no');

        $display_array=array();
        foreach($this->field_list as $f){
        	if($_GET[$f]) $display_array[] = $f;
        }
        if($_GET['sno']) $grid->addColumn('sno','sno');
        $grid->setModel($m,$display_array);
		
		// $grid->add('misc/Export');
	
	}
}