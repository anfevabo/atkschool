<?php

class View_MS_MainBlock extends View {
	var $class;
	var $student;
	var $in_block;

	function init(){
		parent::init();

		$class = $this->add('Model_Class')->load($this->class);
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
					
		$marks_array=array('subjects'=>array(),'exams'=>array(),'blocks'=>array());
		$exam_wise_sum=array();

		foreach($block=$mark_sheet->ref('MainBlock') as $block_junk){
			$block_sum=0;
			foreach ($exam=$block->ref('MainBlockExam') as $exam_junk) {
				// Collecting all exam names here
				if(! in_array("<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>",$marks_array['exams'])){
						$marks_array['exams'][] = "<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>";
				}

				$exam_subjects=$this->add('Model_ExamClassSubjectMap');
				$exam_subjects->addCondition('exammap_id',$exam['exammap_id']);
				$exam_subjects->addCondition('in_block',$this->in_block);
				$exam_subjects->_dsql()->order('in_ms_row');

				foreach($exam_subjects as $exam_subject_junk){
					// Collecting all Subjects name in array
					if(! in_array("<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>",$marks_array['subjects'])){
						$marks_array['subjects'][] = "<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>";
					}

					$marks=$this->add('Model_Students_Marks');
					$marks->addCondition('student_id',$this->student);
					$marks->addCondition('examsub_map_id',$exam_subjects->id);
					$marks->tryLoadAny();
					$marks_array[$block['name']]["<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>"]["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] = $marks['marks'];
					$block_sum += $marks['marks'];
					$exam_wise_sum["<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>"] += $marks['marks'];
					$marks_array[$block['name']][$block['total_title']]["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] += $marks['marks'];
				}
			}
			if($block['is_total_required']){
				$marks_array['exams'][]=$block['total_title']; //Block Total Field Title;
			}

			$marks_array['blocks'][] = $block['name'];
		}
		
		// echo "<pre>";
		// print_r($marks_array);
		// echo "</pre>";

		$table="
		<style>
			.marksheet td{
				border: 1px solid black;
			}
		</style>

		<table class='marksheet' style='border:2px solid red' border=2 width='100%'>";

		// Main Block Heading

		$table .= "<tr>";
		$table .="<td rowspan=2>Vishay</td>";
		foreach($block=$mark_sheet->ref('MainBlock') as $block_junk){
			$colspan= $block->ref('MainBlockExam')->count()->getOne();
			if($block['is_total_required']) $colspan++;
			$table .= "<td colspan='$colspan'>". $block['name'] ."</td>";
		}

		$table .= "</tr>";

		$table .=" <tr>";
		foreach($marks_array['exams'] as $exam){
			$table.= "<td>".$exam ."</td>";
		}
		$table .= "</tr>";

		foreach($marks_array['subjects'] as $sub){
			$table .= "<tr>";
			$table .= "<td>". $sub ."</td>";
			foreach($marks_array['blocks'] as $block){
				foreach($marks_array['exams'] as $exam){
					if(isset($marks_array[$block][$exam])){ //Since every block does not have all exams
						if(isset($marks_array[$block][$exam][$sub])){
							$table .= "<td>".$marks_array[$block][$exam][$sub]."</td>";
						}else{
							$table .= "<td>-</td>";
						}
					}
				}
			}
			$table .= "</tr>";
		}

		// Total at bottom row
		$table .=" <tr>";
		$table .= "<td>Total</td>";
		foreach($marks_array['exams'] as $exam){
			$table.= "<td>".$exam_wise_sum[$exam] ."</td>";
		}
		$table .= "</tr>";


		$table .= "</table>"; 

		$this->add('Text')->setHtml($table);

	
	}
}