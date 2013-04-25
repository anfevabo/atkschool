<?php

class View_MS_Front extends View{
	var $student;

	function init(){
		parent::init();

	}

	function defaultTemplate(){
		return array('view/marksheet/front');
	}
}