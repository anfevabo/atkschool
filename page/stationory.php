<?php
class page_stationory extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$t=$this->add('Model_Item');
		$t->addCondition('is_stationory',true);
		$grid->setModel($t);

	}
}