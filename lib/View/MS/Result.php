<?php

class View_MS_Result extends View {
	var $result;
	var $division;
	var $distinction;
	var $rank;
	var $grace;
	var $supplimentry;

	function init(){
		parent::init();
		$this->template->trySet('final_result',$this->result['final_result']);
		$this->template->trySet('percentage',round($this->result['percentage'],2));
		$this->template->trySet('division',$this->result['division']);
		$this->template->trySet('rank_in_class',$this->rank);

		$dist="";
		foreach($this->distinction as $sub){
			$dist .= "<tr><td>";
			$dist .= $sub;
			$dist .= "</td></tr>";
		}
		$this->template->trySetHTML('distinction',$dist);

		// print_r($this->grace);

		$gr="";
		foreach($this->grace as $grace){
			$sub=array_keys($grace);
			$sub=$sub[0];
			$num = array_values($grace);
			$num=$num[0];
			$gr.="<tr><td>".$sub."</td><td>".$num."</td></tr>";
		}
		$this->template->trySetHTML('grace',$gr);
		
	}

	function defaultTemplate(){
		return array('view/marksheet/result');
	}
}