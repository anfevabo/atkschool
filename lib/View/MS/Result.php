<?php

class View_MS_Result extends View {
	var $result;
	var $division;
	var $distinction;
	var $rank;

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
		
	}

	function defaultTemplate(){
		return array('view/marksheet/result');
	}
}