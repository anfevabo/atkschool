<?php

class View_Scholar extends View{
	function init(){
		parent::init();

	}

	function setModel($scholar){

		$this->add('View_Scholar_Details',null,'details_location')->setModel($scholar->ref('Student'));



		parent::setModel($scholar);
	}

	function defaultTemplate(){
		return array('view/tc');
	}
}