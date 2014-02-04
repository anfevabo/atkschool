<?php
class page_store_mesh extends Page{
function page_index(){
	// parent::init();

	$this->add('H1')->set('Mesh Inward And Consume');
	$grid=$this->add('Grid');
	$party=$this->add('Model_Party');
	$party->addCondition('is_mesh_supplier',true);
	$grid->setModel($party);
	$grid->addQuickSearch(array('ename'));
	$grid->addColumn('button','add_mesh_inward');
	$grid->addColumn('expander','inwardDetail');

	if($_GET['add_mesh_inward']){
		$this->js()->univ()->frameURL('Add Mesh Inward',$this->api->url('store_meshinward',array('party_id'=>$_GET['add_mesh_inward'])))->execute();
	}

}

function page_inwardDetail(){
	$this->api->stickyGET('party_master_id');
	$crud=$this->add('CRUD',array('allow_add'=>false));
	$mi=$this->add('Model_Mesh_ItemInward');
	$mi->addCondition('party_id',$_GET['party_master_id']);
	$mi->_dsql()->order('id','desc');
	$crud->setModel($mi);
	if($crud->grid){

	$crud->grid->addQuickSearch(array('item','party'));
	$crud->grid->addPaginator(10);
	$crud->grid->addFormatter('item','hindi');
	$crud->grid->addFormatter('party','hindi');
	}
}

}