<?php
class page_store_mesh extends Page{
function page_index(){
	// parent::init();
	$cols=$this->add('Columns');
	$col1=$cols->addColumn(12);
	// $col2=$cols->addColumn(6);
	$col1->add('H1')->set('Inward Mesh Item');
	$grid=$col1->add('Grid');
	$party=$this->add('Model_Party');
	$party->addCondition('is_mesh_supplier',true);
	$grid->setModel($party);
	$grid->addQuickSearch(array('ename'));
	$grid->addColumn('button','add_mesh_inward');
	$grid->addColumn('button','consume');
	$grid->addColumn('expander','inwardDetail');
	$grid->addColumn('expander','consumeDetail');

	if($_GET['add_mesh_inward']){
		$this->js()->univ()->frameURL('Add Mesh Inward',$this->api->url('store_meshinward',array('party_id'=>$_GET['add_mesh_inward'])))->execute();
	}

	if($_GET['consume']){
		$this->js()->univ()->frameURL('Consume',$this->api->url('store_meshconsume',array('party_id'=>$_GET['consume'])))->execute();
	}
}

function page_inwardDetail(){
	$this->api->stickyGET('party_master_id');
	$grid=$this->add('Grid');
	$mi=$this->add('Model_Mesh_ItemInward');
	$mi->addCondition('party_id',$_GET['party_master_id']);
	$grid->setModel($mi);
	$grid->addFormatter('item','hindi');
	$grid->addFormatter('party','hindi');
}

function page_consumeDetail(){
	$this->api->stickyGET('party_master_id');
		
}
}