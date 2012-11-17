<?php

class View_Mapping extends View {
	
	var $leftModel;
	var $mappingModel;
	var $rightModel;
	
	var $leftField;
	var $rightField;

	var $fieldsToShowInGrid;	
	var $deleteFirst;
	var $maintainSession;

	var $allowediting=true;

	var $onlymapped=false;

	var $grid;

	function init(){
		parent::init();
		// $this->add('Text')->set($this->rightModel);
		$this->addClass('atk-box ui-widget-content ui-corner-all')
		        ->addStyle('background','#eee');

		$map=$this->leftModel->ref($this->mappingModel);
        $this->grid=$this->add('Grid');
        $grid=$this->grid;
        if(is_string($this->rightModel))
	        $rm=$this->add("Model_".$this->rightModel);
	    else
	    	$rm=$this->rightModel;
	    
        if(!$this->onlymapped)
			$this->grid->setModel($rm);
		else
			$this->grid->setmodel($map);

		if($this->allowediting){
			$form=$this->add('Form');
			$sel=$form->addField('line','sel');
			$sel->js(true)->closest('.atk-form-row')->hide();
			$sel->set(json_encode($map->dsql()->del('field')->field( $this->rightField )->execute()->stmt->fetchAll(PDO::FETCH_COLUMN)));

			$grid->addSelectable($sel);
			$form->addSubmit('Save');

			if($form->isSubmitted()){
				$this->api->db->beginTransaction();

	            // delete old mappings
	            if($this->deleteFirst) $map->deleteAll();

	            $ids= json_decode($form->get('sel'));

	            $session=$this->add('Model_Sessions_Current')->tryLoadAny()->get('id');
		    	foreach($ids as $id){
		    		$tmp=array($this->leftField => $this->leftModel->id, $this->rightField=>$id);
		    		if($this->maintainSession){
		    			$tmp += array('session_id' => $session);
		    		}
		    		$res[]=$tmp;
		    	}

		    	$this->leftModel->ref($this->mappingModel)->dsql()->insertAll($res);

	            $this->api->db->commit();
	            $this->js()->univ()->closeExpander()->successMessage('Mapping saved')->execute();
			}
		}

	}
}