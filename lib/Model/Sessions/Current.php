<?php
class Model_Sessions_Current extends Model_SessionAll {
	function init(){
		parent::init();
		$this->addCondition('iscurrent',true);
	}
}