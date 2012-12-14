<?php

class page_student_attendance extends Page{
	function init(){
		parent::init();

        try{
    		$form=$this->add('Form',null,null,array('form_horizontal'));
    		$class_field=$form->addField('dropdown','class')->setEmptyText('----')->setNotNull()->setAttr('class','hindi');
       	 	$cm=$this->add('Model_Class');
    		$class_field->setModel($cm);
    		$month=$form->addField('dropdown','month')->setEmptyText('----')->setNotNull();
            $month->setValueList(array('1'=>'Jan',
            							'2'=>'Feb',
            							'3'=>'March',
            							'4'=>'April',
            							'5'=>'May',
            							'6'=>'Jun',
            							'7'=>'July',
            							'8'=>'Augest',
            							'9'=>'Sep',
            							'10'=>'Oct',
            							'11'=>'Nov',
            							'12'=>'Dec'
            							));
             $att=$form->addField('line','att','Total Monthly Attendance');
            $att->js(true)->univ()->numericField()->disableEnter();
            $form->addSubmit('Allot');

            $grid=$this->add('Grid');

            $sa=$this->add('Model_Students_Attendance');
            if($_GET['filter']){
            	if($_GET['class']) $sa->addCondition('class_id',$_GET['class']);
            	if($_GET['month'])	$sa->addCondition('month',$_GET['month']);
            	// if($_GET['att']) $sa->addCondition('total_attendance',$_GET['att']);
            }
            
            $grid->setModel($sa,array('roll_no','class','student','month','total_attendance','present'));
            $sa->_dsql()->del('order')->order('roll_no','asc');
            $grid->setFormatter('student','hindi');
            $grid->addFormatter('present','grid/inline');
            $grid->addPaginator(50);



            if($form->isSubmitted()){

            	if($form->isSubmitted()){
            		$sam=$this->add('Model_Students_Attendance');
            		$sam->addCondition('class_id',$form->get('class'));
            		$sam->addCondition('month',$form->get('month'));
            		$sam->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
            		$sam->tryLoadAny();
            		if(!$sam->loaded()){
            			$c=$this->add('Model_Class');
            			$c->load($form->get('class'));
            			$c->ref('Students_Current');
            			foreach($c->ref('Students_Current') as $junk){
            				$sam['student_id']=$junk['id'];
            				$sam['total_attendance']=$form->get('att');
            				$sam->saveAndUnload();
            			}
            		}else{
            			if($form->get('att') and $form->get('att')!=$sam['total_attendance']){
            				$sam->unload();
            				$sam->_dsql()->set('total_attendance',$form->get('att'))->update();
            			}
            		}


            		$grid->js(null,$form->js()->reload())->reload(array("class"=>$form->get('class'),
            									"month"=>$form->get('month'),
            									"att"=>$form->get('att'),
            									"filter"=>1
            									))->execute();


            	}
            	
            }
        }catch(Exception $e){
            $this->js()->univ()->errorMessage($e->getMessage())->excute();

        }
	}

}