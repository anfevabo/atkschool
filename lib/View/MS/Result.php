<?php

class View_MS_Result extends View {
	var $result;
	var $division;
	var $rank;

	function init(){
		parent::init();
		$this->template->trySet('final_result',$this->result['final_result']);
		$this->template->trySet('percentage',round($this->result['percentage'],2));
	}

	function defaultTemplate(){
		return array('view/marksheet/result');
	}
}