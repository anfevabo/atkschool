<?php
class page_student_msview extends Page {
	function init(){
		parent::init();

		$c=$this->add('Model_Class')->load($_GET['class']);

		$this->api->memorize('grand_total_max_marks',0);
		$this->api->memorize('grand_total_marks',0);
		$this->api->memorize('distinction_subjects',array());
		$this->api->memorize('examsub_map_id_array',array());


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
		$percentage = round($marks/$max * 100.00,2);
		
		// Result
		if($percentage >= 33) 
			$final_result = 'Pass';
		else
			$final_result = "Fail";
		
		// Division
		if($percentage >=60)
			$division="First";
		elseif($percentage >=50)
			$division="Second";
		elseif($percentage >=33)
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

		$result=array('percentage'=>$percentage,'final_result'=>$final_result,'division'=>$division);
		$this->add('View_MS_Result',array('result'=>$result,'distinction'=>$distinction,'rank'=>$rank),'right_panel');

	}

	function defaultTemplate(){
		return array('view/marksheet/backside');
	}

	function render(){
		$this->api->template->del('header');
		$this->api->template->del('logo');
		$this->api->template->del('Menu');
		$this->api->template->del('date');
		$this->api->template->del('welcome');
		$this->api->template->del('footer_text');

		parent::render();
	}
}