<?php

class page_hostel_studentgardian extends Page{

	function page_index(){
		$grid=$this->add('Grid');
		$r=$this->add('Model_Scholars_Current');
        $r->addCondition('ishostler',true);
        $grid->setModel($r,array('hname','class'));
        // $grid->addFormatter('scholar','hindi');
        $grid->addPaginator();

        $grid->addColumn('expander','manage','Manage');
	}

	function page_manage(){
		$v=$this->add('View');
		$v->addClass('atk-box ui-widget-content ui-corner-all')->addStyle('background','#eee');
		$this->api->stickyGET('scholars_master_id');
		$sc=$this->add('Model_Scholars_Current');
		$sc->load($_GET['scholars_master_id']);

		$crud=$v->add('CRUD');
		
		$crud->setModel($sc->ref('Scholars_Guardian'),null,array('gname','contact','relation','image'));
	}
}