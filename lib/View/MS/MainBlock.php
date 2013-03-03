<?php

class xTd{
	var $value;
	var $attributes;

	function render(){
		$mycell="<td $this->attributes >$this->value</td>";
		return $mycell;
	}
}

class xTr{
	var $Td = array();
	var $attributes;

	function render(){
		$myrow="<tr $this->attributes>";
		foreach($this->Td as $td){
			$myrow .= $td->render();
		}
		$myrow .= "</tr>";
		return $myrow;
	}
}

class xTable {
	var $Tr = array();
	var $attributes;

	function render(){
		$mytable="
		<style>
			.marksheet td{
				border: 1px solid black;
			}
		</style>
		<table stype='border:1px solid black;' width='100%' class='marksheet'>";
		foreach ($this->Tr as $tr) {
			$mytable .= $tr->render();
		}
		$mytable .= "</table>";
		return $mytable;
	}
}

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

		$MM_4_Each_Row=$section['max_marks_for_each_subject'];
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
					
		$block_exam_subject_marks=array();
		$block_exam_sum=array();
		$block_subject_sum=array();
		$subject_sum=array();
		$subject_max_marks_sum =array();
		$block_exam_subject_max_marks=array();
		$block_subject_max_marks_sum=array();
		$block_exam_max_marks_sum=array();
		$block_exam_marks_sum=array();
		$block_max_marks_sum=array();
		$block_marks_sum=array();

		$grand_total_marks=0;
		$grand_total_max_marks=0;

		$subjects=array();
		$exams=array();
		$blocks=array();
		$blocks_exam_count = array();
		$block_exams=array();
		$blocks_exams_subjects=array();
		$blocks_total_fields=array();
		$total_in_blocks=array();

		$examsub_map_id_array=array();

		foreach($subs=$section->ref('MS_SectionSubjects') as $secsub_junk){
			$subjects[] = "<span class='hindi'>".$subs->ref('subject_id')->get('name')."</span>";
		}

		foreach($block=$section->ref('MS_SectionBlocks') as $block_junk){
			$block_name=$block['name'];
			$blocks[] = $block_name;
			$blocks_exam_count[$block_name]= $block->ref('MS_BlockExams')->count()->getOne();
			foreach ($exam=$block->ref('MS_BlockExams') as $exam_junk) {
				$exam_name="<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>";
				$block_exams[$block_name][]=$exam_name;
				if(! in_array($exam_name,$exams)){
						$exams[] = "<span class='hindi'>".$exam->ref('exammap_id')->get('name')."</span>";
				}
				$exam_subjects=$this->add('Model_ExamClassSubjectMap');
				$exam_subjects->addCondition('exammap_id',$exam['exammap_id']);
				// $exam_subjects->addCondition('marksheet_section_id',$this->section);
				$exam_subjects->_dsql()->order('in_ms_row');
				foreach($exam_subjects as $exam_subject_junk){
					$subject_name = "<span class='hindi'>".$exam_subjects->ref('subject_id')->get('name')."</span>";
					$blocks_exams_subjects[$block_name][$exam_name][] = $subject_name;
					if(!in_array($subject_name, $subjects)) continue;
					// if(! in_array($subject_name,$subjects)){
					// 	$subjects[] = $subject_name;
					// }
					$examsub_map_id_array[] = $exam_subjects->id;
					$marks=$this->add('Model_Students_Marks');
					$marks->addCondition('student_id',$this->student);
					$marks->addCondition('examsub_map_id',$exam_subjects->id);
					$marks->tryLoadAny();

					$block_exam_subject_marks[$block_name][$exam_name][$subject_name]=$marks['marks'];
					$block_exam_sum[$block_name][$exam_name] +=$marks['marks'];
					$block_subject_sum[$block_name][$subject_name] +=$marks['marks'];
					$subject_sum[$subject_name]+=$marks['marks'];
					$subject_max_marks_sum[$subject_name]+=$marks['max_marks'];
					$block_exam_subject_max_marks[$block_name][$exam_name][$subject_name] = $marks['max_marks'];
					$block_subject_max_marks_sum[$block_name][$subject_name] += $marks['max_marks'];
					$block_exam_max_marks_sum[$block_name][$exam_name] += $marks['max_marks'];
					$block_exam_marks_sum[$block_name][$exam_name] += $marks['marks'];
					$block_max_marks_sum[$block_name] += $marks['max_marks'];
					$block_marks_sum[$block_name] += $marks['marks'];
					$grand_total_marks +=$marks['marks'];
					$grand_total_max_marks +=$marks['max_marks'];
				}
			}
			if($block['is_total_required']){
				$total_in_blocks[] = $block_name;
				$blocks_total_fields[$block_name]=$block['total_title'];
			}
		}

		// TABLE start
		$table = new xTable();
		
		// TOP ROW SUBJECT and BLOCKS
		$cur_row = $table->Tr[] = new xTr();
		$cur_td = $cur_row->Td[] = new xTd();
		$cur_td->value = "Vishay";
		$cur_td->attributes = "rowspan=2";
		if($MM_4_Each_Row){
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = "Purnank";
			$cur_td->attributes="rowspan=2";
		}
		foreach($blocks as $block_junk){
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = $block_junk;
			$colspan=$blocks_exam_count[$block_junk];
			if(in_array($block_junk, $total_in_blocks)) $colspan++;
			$cur_td->attributes = "colspan=" . $colspan;
		}

		if($section['has_grand_total']){
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = "Sarv Yog";
			$cur_td->attributes="rowspan=2";
		}

		// Exam RoW
		$cur_row = $table->Tr[] = new xTr();
		foreach($blocks as $block_junk){
			foreach($block_exams[$block_junk] as $be){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->value = $be;
			}
			if(in_array($block_junk, $total_in_blocks)){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->value = $blocks_total_fields[$block_junk];	
			}
		}

		// PURNANK ROW if not for each row
		if(!$MM_4_Each_Row){
			$cur_row = $table->Tr[] = new xTr();
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = "Purnank";
			foreach($blocks as $block_junk){
				foreach($block_exams[$block_junk] as $exam){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->attributes="style='font-weight:bold'";
					$cur_td->value = $block_exam_subject_max_marks[$block_junk][$exam][$subjects[0]];
				}
				if(in_array($block_junk, $total_in_blocks)){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->attributes="style='font-weight:bold'";
					$cur_td->value = $block_subject_max_marks_sum[$block_junk][$subjects[0]];
				}
			}
			
			if($section['has_grand_total']){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->attributes="style='font-weight:bold'";
				$cur_td->value = $subject_max_marks_sum[$subjects[0]];
			}
		}

		// Each Subjects Row
		foreach($subjects as $sub){
			$cur_row = $table->Tr[] = new xTr();
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = $sub;
			if($MM_4_Each_Row){ //IF each row has max marks to be shown
				$cur_td->attributes = "rowspan=2";
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->value = "Purnank<br>Praptank";
				$cur_td->attributes="rowspan=2";
				foreach($blocks as $block_junk){
					foreach($block_exams[$block_junk] as $exam){
						$cur_td = $cur_row->Td[] = new xTd();
						$cur_td->attributes="style='font-weight:bold'";
						$cur_td->value = $block_exam_subject_max_marks[$block_junk][$exam][$sub];
					}
					if(in_array($block_junk, $total_in_blocks)){
						$cur_td = $cur_row->Td[] = new xTd();
						$cur_td->attributes="style='font-weight:bold'";
						$cur_td->value = $block_subject_max_marks_sum[$block_junk][$sub];
					}		
				}	
				
				if($section['has_grand_total']){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->attributes="style='font-weight:bold'";
					$cur_td->value = $subject_max_marks_sum[$sub];
				}

				// Add new row for achieved marks
				$cur_row = $table->Tr[] = new xTr();
			}
			// Add Achived Marks Row
			foreach($blocks as $block_junk){
				foreach($block_exams[$block_junk] as $exam){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->value = $block_exam_subject_marks[$block_junk][$exam][$sub];
				}
				if(in_array($block_junk, $total_in_blocks)){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->value = $block_subject_sum[$block_junk][$sub];
				}
			}
			if($section['has_grand_total']){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->attributes="style='font-weight:bold'";
				$cur_td->value = $subject_sum[$sub];
			}
		}

		// Total in Sections as bottom TR
		$cur_row = $table->Tr[] = new xTr();
		$cur_td = $cur_row->Td[] = new xTd();
		$cur_td->value = "YOOG";

		if($MM_4_Each_Row){
			$cur_td->attributes = "rowspan=2";
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->value = "Purnank<br>Praptank";
			$cur_td->attributes="rowspan=2";
			foreach($blocks as $block_junk){
				foreach($block_exams[$block_junk] as $exam){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->attributes="style='font-weight:bold'";
					$cur_td->value = $block_exam_max_marks_sum[$block_junk][$exam];
				}
				if(in_array($block_junk, $total_in_blocks)){
					$cur_td = $cur_row->Td[] = new xTd();
					$cur_td->attributes="style='font-weight:bold'";
					$cur_td->value = $block_max_marks_sum[$block_junk];
				}
			}	

			if($section['has_grand_total']){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->attributes="style='font-weight:bold'";
				$cur_td->value = $grand_total_max_marks;
			}
			
			$cur_row = $table->Tr[] = new xTr();
		}

		foreach($blocks as $block_junk){
			foreach($block_exams[$block_junk] as $exam){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->attributes="style='font-weight:bold'";
				$cur_td->value = $block_exam_marks_sum[$block_junk][$exam];
			}
			if(in_array($block_junk, $total_in_blocks)){
				$cur_td = $cur_row->Td[] = new xTd();
				$cur_td->attributes="style='font-weight:bold'";
				$cur_td->value = $block_marks_sum[$block_junk];
			}
		}

		if($section['has_grand_total']){
			$cur_td = $cur_row->Td[] = new xTd();
			$cur_td->attributes="style='font-weight:bold'";
			$cur_td->value = $grand_total_marks;
		}

		$this->add('Text')->setHtml($table->render());

		$distinction_subjects=array();
		if($section['grade_decider']){
			$this->api->memorize('grand_total_max_marks',$this->api->recall('grand_total_max_marks',0)+$grand_total_max_marks);
			$this->api->memorize('grand_total_marks',$this->api->recall('grand_total_marks',0)+$grand_total_marks);

			foreach($subjects as $sub){
				if($subject_max_marks_sum[$sub] !=0){
					if(($subject_sum[$sub] / $subject_max_marks_sum[$sub] * 100) >= 75)
						$distinction_subjects[] = $sub;
				}
			}

			$this->api->memorize('distinction_subjects',$this->api->recall('distinction_subjects',array())+$distinction_subjects);
			$this->api->memorize('examsub_map_id_array',$this->api->recall('examsub_map_id_array',array())+$examsub_map_id_array);

		}

	}

	function pr($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}