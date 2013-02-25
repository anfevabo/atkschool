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
			$this->js()->univ()->newWindow($this->api->url("student_msview",array('class'=>$form->get('class'),'student'=>$form->get('students'))),null,'height=689,width=1246,scrollbar=1')->execute();
		}
	}

	function page_marksheets(){
		$class = $this->add('Model_Class')->load($_GET['class']);
		$mark_sheet = $class->ref('MarksheetDesigner')->tryLoadAny();

		/*
			MAIN BLOCK DESIGNING
			FOREACH BLOCKS
				FOREACH EXAMS
					IF First time getting Exams
						array[0][subjects][]=exam_name
					array[BLOCK][EXAM][SUBJECT][Marks]= Marks_Obtained
					array[BLOCK][EXAM][SUBJECT][Max_Marks]= Max_Marks
					IF Block Required Total
						array[BLOCK][EXAM][SUBJECT][TOTAL] += Marks_Obtained
					array[EXAM][SUBJECT][GRAND_TOTAL] += Marks_Obtained
		*/
					
		$marks_array=array('subjects'=>array(),'exams'=>array(),'blocks'=>array(),'totals'=>array(),'grand_total'=>array());

		foreach($block=$mark_sheet->ref('MainBlock') as $block_junk){
			foreach ($exam=$block->ref('MainBlockExam') as $exam_junk) {
				// Collecting all exam names here
				if(! in_array("<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>",$marks_array['exams'])){
						$marks_array['exams'][] = "<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>";
				}

				$exam_subjects=$this->add('Model_ExamClassSubjectMap');
				$exam_subjects->addCondition('exammap_id',$exam['exammap_id']);
				foreach($exam_subjects as $exam_subject_junk){
					// Collecting all Subjects name in array
					if(! in_array("<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>",$marks_array['subjects'])){
						$marks_array['subjects'][] = "<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>";
					}

					$marks=$this->add('Model_Students_Marks');
					$marks->addCondition('student_id',$_GET['student']);
					$marks->addCondition('examsub_map_id',$exam_subjects->id);
					$marks->tryLoadAny();
					$marks_array[$block['name']]["<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>"]["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] = ($marks['marks'] == "" ? "-": $marks['marks']);
					if($block['is_total_required']){
						$marks_array['totals'][$block['name']]["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] += $makrs['marks'];
					}
					$marks_array['grand_total']["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] += $marks['marks'];
				}
			}
			if($block['is_total_required']){
				$marks_array['exams'][]="Total";
			}

			$marks_array['blocks'][] = $block['name'];
		}
		echo "<pre>";
		print_r($marks_array);
		echo "</pre>";

		$table="
		<style>
			.marksheet td{
				border: 1px solid black;
			}
		</style>

		<table class='marksheet' style='border:2px solid red' border=2 width='100%'>";

		// Main Block Heading
		$table .=" <tr>";
		$table .="<td>Vishay</td>";
		foreach($marks_array['exams'] as $exam){
			$table.= "<td>".$exam ."</td>";
		}
		$table .= "</tr>";

		foreach($marks_array['subjects'] as $sub){
			$table .= "<tr>";
			$table .= "<td>". $sub ."</td>";
			foreach($marks_array['blocks'] as $block){
				foreach($marks_array['exams'] as $exam){
					if(isset($marks_array[$block][$exam][$sub])){ //Since every block does not have all exams
						$table .= "<td>".$marks_array[$block][$exam][$sub]."</td>";
					}
				}
			}
			$table .= "</tr>";
		}


		$table .= "</table>"; 

		$this->add('Text')->setHtml($table);

	}

}