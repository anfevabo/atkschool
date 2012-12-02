<?php
class page_store_iteminward extends Page {

	function page_index(){
		$acl=$this->add('xavoc_acl/Acl');
		$grid=$this->add('Grid');

		$pm=$this->add('Model_Party');
		$grid->setModel($pm);

		$grid->addColumn('Button','add_inward');
		if($_GET['add_inward']){
			$grid->js()->univ()->frameURL("Manage Bills",$this->api->url('./partybills',array('party_id'=>$_GET['add_inward'])))->execute();
		}
	}

	function page_partybills(){
		$this->api->stickyGET('party_id');
		$pm=$this->add('Model_Party');
		$pm->load($_GET['party_id']);

		$crud=$this->add('CRUD');
		$crud->setModel($pm->ref('Bill'),array('name','bill_date','inward_date','paid','cheque_date','cheque_number','no_of_items','bill_amount'));
		if($crud->grid){
			$crud->grid->addColumn('Expander','details');
		}
	}


	function page_partybills_details(){
		$v=$this->add('View')->setClass('atk-box ui-widget-content');
		$this->api->stickyGET('bill_master_id');
		$bill=$this->add('Model_Bill');
		$bill->load($_GET['bill_master_id']);

		$crud=$v->add('CRUD');
		$crud->setModel($bill->ref('Item_Inward'));

		if($crud->grid){
			$crud->grid->setFormatter('item','hindi');
		}

		if($crud->form){
			$crud->form->getElement('item_id')->setAttr('class','hindi');
		}


	}
}