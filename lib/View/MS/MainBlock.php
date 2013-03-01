<?php

class View_MS_MainBlock extends View {
	
	var $class;
	var $student;
	var $section;

	var $save_results=false;

	function init(){
		parent::init();

		$class = $this->add('Model_Class')->load($this->class);
		$mark_sheet = $class->ref('MS_Designer')->tryLoadAny();

		$section=$mark_sheet->ref('MS_Sections')->addCondition('id',$this->section)->tryLoadAny();

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
					
		$marks_array=array('subjects'=>array(),'exams'=>array(),'blocks'=>array(),'blocks_total_fields'=>array());
		$exam_wise_sum=array();
		$Max_Marks=array();
		$distinctions_subjects=array();
		$grand_total=array();
		$grand_max_marks=0;

		foreach($block=$section->ref('MS_SectionBlocks') as $block_junk){
			$block_sum=0;
			$block_max_sum=0;
			foreach ($exam=$block->ref('MS_BlockExams') as $exam_junk) {
				// Collecting all exam names here
				if(! in_array("<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>",$marks_array['exams'])){
						$marks_array['exams'][] = "<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>";
				}

				$exam_subjects=$this->add('Model_ExamClassSubjectMap');
				$exam_subjects->addCondition('exammap_id',$exam['exammap_id']);
				$exam_subjects->addCondition('marksheet_section_id',$this->section);
				$exam_subjects->_dsql()->order('in_ms_row');
				// $exam_subjects->debug();

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
					$grand_total["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] += $marks['marks'];
					$exam_wise_sum["<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>"] += $marks['marks'];
					$marks_array[$block['name']][$block['total_title']]["<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>"] += $marks['marks'];
				}

				$Max_Marks[$block['name']]["<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>"] = $exam['max_marks'];
				$grand_max_marks += $exam['max_marks'];
				$block_max_sum += $exam['max_marks'];
			}

			if($block['is_total_required']){
				$marks_array['exams'][]=$block['total_title']; //Block Total Field Title;
				$marks_array['blocks_total_fields'][] = $block['total_title'];
				$Max_Marks[$block['name']][$block['total_title']] = $block_max_sum;
			}

			$marks_array['blocks'][] = $block['name'];
		}

		if($section['has_grand_total']){
			$marks_array['exams'][]="Grand Total"; //Block Total Field Title;
			// $marks_array['blocks_total_fields'][] = $block['total_title'];
			$Max_Marks[$section['name']]["Grand Total"] = $grand_max_marks;
		}
		
		if($this->save_results){
			$total_obtained=0;
			foreach($exam_wise_sum as $ews){
				$total_obtained += $ews;
			}
			$this->api->memorize('percentage',$total_obtained / $grand_max_marks * 100.00 );
		}

		// echo "<pre>";
		// print_r($exam_wise_sum);
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
		foreach($block=$section->ref('MS_SectionBlocks') as $block_junk){
			$colspan= $block->ref('MS_BlockExams')->count()->getOne();
			if($block['is_total_required']) $colspan++;
			$table .= "<td colspan='$colspan'>". $block['name'] ."</td>";
		}

		$table .= "</tr>";

		$table .=" <tr>";
		foreach($marks_array['exams'] as $exam){
			$table.= "<td>".$exam ."</td>";
		}
		$table .= "</tr>";

		// Max Marks row

		$table .= "<tr>";
		$table .= "<td>Purnank</td>";
		foreach($Max_Marks as $block){
			foreach ($block as $mm) {
				$table .= "<td>". $mm ."</td>";
			}
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

			// Grand Total TD at last
			if($section['has_grand_total']){
				$table .= "<td>".$grand_total[$sub]."</td>";
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