<?php
class page_store_stock extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$grid=$this->add('Grid');
		$grid->setModel('Item',array('name','LastPurchasePrice','TotalInward','TotalIssued','instock'));
	}
}