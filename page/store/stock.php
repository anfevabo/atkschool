<?php
class page_store_stock extends Page {
	function init(){
		parent::init();
// 		$acl=$this->add('xavoc_acl/Acl');
// 		$form=$this->add('Form');
// 		$form_cat=$form->addField('dropdown','category')->setEmptyText('----')->setAttr('class','hindi');
// 		$form_cat->setModel('Item_Category');
// 		$form->addSubmit('GetList');
// 		$grid=$this->add('Grid');
// 		$item=$this->add('Model_Item_Category');
// 		if($_GET['filter']){
// 			$item->addCondition('name',$_GET['category']);
// 		}



// 		$grid->setModel($item,array('name','LastPurchasePrice','TotalInward','TotalIssued','instock'));
// 		if($form->isSubmitted()){
			
// 			$grid->js()->reload(array("category"=>$form->get('category'),
// 										"filter"=>-1))->execute();
// 		}

		$tab=$this->add('Tabs');
		$tab->addTabURL('stationory','Stationory');
		$tab->addTabURL('other','Other Item(Mess)');
	}
}