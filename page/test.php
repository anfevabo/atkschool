<?php

class page_test extends Page {
	function init(){
		parent::init();

		$item=$this->add('Model_Students_Current');
		$item->removeCondition('session_id');
		$grid=$this->add('Grid');
		$grid->setModel($item);
  


	}

	}
	