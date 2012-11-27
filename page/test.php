<?php

class page_test extends Page {
	function page_index(){
		$m=$this->add('Model_Scholars_Current');
		$m->load(15);
		$m['contact']=111;
		$m['class_id']=16;

		$m->debug()->save();

	}
}	