<?php

class View_MS_Attendance extends View {
	function init(){
		parent::init();
	}

	function setModel($m){
		foreach($m as $junk){
			$this->template->trySet("total_".$m['month'], $m['total_attendance']);
			$this->template->trySet("att_".$m['month'], $m['present']);
		}
		parent::setModel($m);
	}

	function defaultTemplate(){
		return array('view/marksheet/attendance');
	}
}