<?php

class Model_RelatedClass extends Model_Class{
	function init(){
		parent::init();
		$this->join('subject_class_map','class_id');
	}
}