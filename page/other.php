<?php
class page_other extends Page{
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$t=$this->add('Model_Item');
		$t->addCondition('is_stationory',false);
		$grid->setModel($t);
	}
}