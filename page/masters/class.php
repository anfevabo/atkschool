<?php

class page_masters_class extends Page {
	function page_index(){
		$crud=$this->add('CRUD');
		$crud->setModel('Class',array('class_name','section'));
		if($crud->grid){
			$crud->grid->addColumn('Expander','subjects');
		}
	}

	function page_subjects(){
		$this->api->stickyGET('class_master_id');

		$p=$this->add('View')->addClass('atk-box ui-widget-content ui-corner-all')
        ->addStyle('background','#eee');

		$class=$this->add('Model_Class');
		$class->load($_GET['class_master_id']);

		$grid=$p->add('Grid');
		$grid->setModel('Subject',array('name','code'));

		$form=$this->add('Form');
		$sel=$form->addField('line','sel');
		$sel->js(true)->closest('.atk-form-row')->hide();

		$map=$class->ref('SubjectClassMap');
		$sel->set(json_encode($map->dsql()->del('field')->field('subject_id')->execute()->stmt->fetchAll(PDO::FETCH_COLUMN)));
		$grid->addSelectable($sel);

		$form->addSubmit('Save');

		if($form->isSubmitted()){
			$this->api->db->beginTransaction();

            // delete old mappings
            $map->deleteAll();
            $class->setSubjects(json_decode($form->get('sel')));

            $this->api->db->commit();
            $this->js()->univ()->closeExpander()->successMessage('Mapping saved')->execute();
		}
	}
}