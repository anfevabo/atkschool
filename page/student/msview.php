<?php
class page_student_msview extends Page {
	function init(){
		parent::init();

		$c=$this->add('Model_Class')->load($_GET['class']);

		$this->api->memorize('grand_total_max_marks',0);
		$this->api->memorize('grand_total_marks',0);
		$this->api->memorize('distinction_subjects',array());
		$this->api->memorize('examsub_map_id_array',array());
		$this->api->memorize('failed_subjects',array());


		$topStudentView=$this->add('View_MS_StudentDetails',null,'student_panel');
		$topStudentView->setModel($this->add('Model_Student')->load($_GET['student']));
		$first=true;

		foreach($marksheet=$c->ref('MS_Designer') as $marksheet_junk){
			foreach($section = $marksheet->ref('MS_Sections') as $section_junk){
				$v=$this->add('View_MS_MainBlock',array('class'=>$_GET['class'],'student'=>$_GET['student'],'section'=>$section->id,'save_results'=>$first));
				$first=false;
			}
		}
		
		// Percentage
		$max=$this->api->recall('grand_total_max_marks',0);
		$marks=$this->api->recall('grand_total_marks',0);
		$grace=array();
		$supplimentry=array();

		$failed_subjects=$this->api->recall('failed_subjects',array());
		// print_r($failed_subjects);

		if(count($failed_subjects) ==0){
			$final_result="Pass";
		}
		elseif(count($failed_subjects) > 2){
			// JUST FAIL
			$final_result = 'Fail';
		}else{
			// Grace or suplimentory
			if(count($failed_subjects)==1){
				$failed_subjects_i =array_values($failed_subjects);
				if($failed_subjects_i[0]['diff'] <= $failed_subjects_i[0]['grace_allowed']['5_per']){
					$sub=array_keys($failed_subjects);
					$grace[]=array($sub[0]=>$failed_subjects_i[0]['diff']);
					$final_result='Grace';
				}
				// Or can be suplimentry
				if(count($grace) != 1){
					$grace=array();
					// Check for suplimentry
					if($failed_subjects_i[0]['can_suplimentry'] == '1'){
						foreach($failed_subjects as $subject=>$details){
							if($details['can_suplimentry']){
								$supplimentry[$subject] = $details['diff'];
							}
						}
						$final_result='Suplimentry';
					}else{
						// FAILED
						$supplimentry=array();
						$final_result='Fail';
					}
				}
			}else{
				foreach($failed_subjects as $subject=>$details){
					// Check the two subjects for 2 percent grade range
					if($details['diff'] <= $details['grace_allowed']['2_per']){
						$grace[]=array($subject=>$details['diff']);
						$final_result='Grace';
					}
					// BUT IF both are not in range they might be in supplimentry
					if(count($grace) != 2) {
						$grace=array();
						foreach($failed_subjects as $subject=>$details){
							if($details['can_suplimentry']){
								$supplimentry[$subject] = $details['diff'];
							}
						}
						$final_result='Suplimentry';
					}
					if(count($supplimentry) != 2){
						// NOW YOU ARE FAILED.. NO BODY CAN HELP YOU MAN.. AB PADHAI CHALU KARDO BUS
						$supplimentry=array();
						$final_result='Fail';
					}
				}
			}
		}


		if($max != 0)
			$percentage = round($marks/$max * 100.00,2);
		else
			$percentage = 0;

		
		// Result
		if($percentage >= 36 AND $final_result == 'Pass') 
			$final_result = 'Pass';
		
		// Division
		if($percentage >=60 AND $final_result == 'Pass')
			$division="First";
		elseif($percentage >=48 AND $final_result == 'Pass')
			$division="Second";
		elseif($percentage >=36 AND $final_result == 'Pass')
			$division="Third";
		else
			$division="-";

		// Rank
		$students_ar=$this->add('Model_Students_Current')->addCondition('class_id',$c->id)->_dsql()->del('field')->field('id')->getAll();
		foreach($students_ar as $s){
			$students[]=$s['id'];
		}

		$examsub_map_id_array=$this->api->recall('examsub_map_id_array');

		$all_class_students_marks=$this->add('Model_Students_Marks')
									->addCondition('student_id','in', $students)
									->addCondition('examsub_map_id','in',$examsub_map_id_array)
									->_dsql()
									->del('field')
									->field('student_id')
									->field($this->api->db->dsql()->expr('SUM(marks) marks'))
									->group('student_id')
									->order('marks','desc')
									->getAll()
									;

		// print_r($all_class_students_marks);

		$rank=1;
		foreach ($all_class_students_marks as $sm) {
			if($sm['student_id'] == $_GET['student']) break;
			$rank++;
		}

		// Grace
		// result declare date
		// Distinction
		$distinction = $this->api->recall('distinction_subjects',array());

		$result=array(
			'percentage'=>$percentage,
			'final_result'=>$final_result,
			'division'=>$division
			);
		$this->add('View_MS_Result',array('result'=>$result,'distinction'=>$distinction,'rank'=>$rank,'grace' =>$grace,'supplimentry'=>$supplimentry),'right_panel');
		$this->api->add('H1',null,'header')->setAttr('align','center')->setHTML('Bal Vinay Uchch Madhyamik Vidhyalay, Udaipur');
		$fv=$this->add('View_MS_Front',null,'marksheet_front');
		$fv->setModel($this->add('Model_Student')->load($_GET['student']));
	}

	function defaultTemplate(){
		return array('view/marksheet/marksheet');
	}

	function render(){
		// $this->api->template->del('header');
		$this->api->template->del('logo');
		$this->api->template->del('Menu');
		$this->api->template->del('date');
		$this->api->template->del('welcome');
		$this->api->template->del('footer_text');

		parent::render();
	}
}