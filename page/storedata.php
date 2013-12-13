<?php

class page_storedata extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('store_studentstore','Student Store');
		$tabs->addTabURL('store_iteminward','Item Inward');
		$tabs->addTabURL('store_itemoutward','Stationory Item Outward');
		$tabs->addTabURL('store_stock','Item Stocks');
		// $tabs->addTabURL('store_all','All Stocks');
	}
}