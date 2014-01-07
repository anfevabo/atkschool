<?php
class page_store_stock extends Page {
	function init(){
		parent::init();
		$acl=$this->add('xavoc_acl/Acl');
		$form=$this->add('Form');
		$form_cat=$form->addField('dropdown','category')->setEmptyText('----')->setAttr('class','hindi');
		$form_cat->setModel('Item_Category');
		$form->addSubmit('GetList');
		$grid=$this->add('Grid');
		$item=$this->add('Model_Item');
		if($_GET['filter']){
			$item->addCondition('category_id',$_GET['category']);
		}

		$item->addExpression('inward')->set(function($m,$q){
			$itm=$m->add('Model_Item_Inward');
			$itm->join('bill_master.id','bill_id')->addField('session_id');
			$itm->addCondition('item_id',$m->getField('id'));
			return $itm->sum('quantity');
		});

		$grid->setModel($item,array('name','LastPurchasePrice','TotalInward','inward','TotalIssued','instock'));
		if($form->isSubmitted()){
			
			$grid->js()->reload(array("category"=>$form->get('category'),
										"filter"=>-1))->execute();
		}

		// $tab=$this->add('Tabs');
		// $tab->addTabURL('stationory','Stationory');
		// $tab->addTabURL('other','Other Item(Mess)');
	}
}