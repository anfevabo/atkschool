<?php

class page_storedata extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('store_iteminward','Item Inward');
		$tabs->addTabURL('store_itemoutward','Item Outward');
		$tabs->addTabURL('store_stock','Item Stocks');
	}
}