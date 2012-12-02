<?php

class page_school_scholars extends Page {
	function init(){
		parent::init();
        $acl=$this->add('xavoc_acl/Acl');
		$crud=$this->add('CRUD',array('allow_del'=>false));
		$crud->setModel('Scholars_Current',null,array('fname','hname','scholar_no','class','image_url'));
		if($crud->grid){
			$crud->grid->addFormatter('class','hindi');
            $crud->grid->addQuickSearch(array('scholar_no','fname'));
             // $crud->grid->add("misc/Controller_AutoPaginator")->setLimit(50);
            $crud->grid->addPaginator();
		}
		if($crud->form){
            // make form flow in 2 columns
            if($crud->form->model->loaded()){
                $crud->form->getElement('class_id')->disable(true)->setFieldHint('You cannot edit class from here now');
            }
            $crud->form->setFormClass('stacked atk-row');
            $o=$crud->form->add('Order')
                ->move($crud->form->addSeparator('noborder span6'),'first')
                ->move($crud->form->addSeparator('noborder span5'),'middle')
                ->now();
            
            $crud->form->getElement('hname')->setAttr('class','hindi');
            $crud->form->getElement('father_name')->setAttr('class','hindi');
            $crud->form->getElement('mother_name')->setAttr('class','hindi');
            $crud->form->getElement('guardian_name')->setAttr('class','hindi');
            $crud->form->getElement('p_address')->setAttr('class','hindi');
            $crud->form->getElement('class_id')->setAttr('class','hindi');
//            $drp_cat=$crud->form->addField('dropdown','categary');
//            $cat=array("ST"=>"ST","SC"=>"SC","OBC"=>"OBC");
//            $drp_cat->setValueList($cat);
        }
	}
}