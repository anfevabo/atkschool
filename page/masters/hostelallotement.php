<?php
class page_masters_hostelallotement extends Page{
	function page_index(){

		$grid=$this->add('Grid');
		$grid->setModel('Class');

		$grid->addColumn('expander','students','Students Of Class');
	}

	function page_students(){
		$this->api->stickyGET('class_master_id');

		$c=$this->add('Model_Class');
		$c->load($_GET['class_master_id']);

		$grid=$this->add('Grid');
		$grid->setModel($c->ref('Student'));
		$grid->addColumn('expander','alott','Allotement');
	}

	function page_students_alott(){

		$this->api->stickyGET('student_id');


		$form=$this->add('Form');
		$hdrp=$form->addField('dropdown','hostel')->setEmptyText('------')->setNotNull();
		$hdrp->setModel('Hostel');

		$rdrp=$form->addField('dropdown','room_no');

		$r=$this->add('Model_HostelRoom');
		if($_GET['hostel_idx']){
			$r->addCondition('hostel_id',$_GET['hostel_idx']);
			// throw $this->exception("hi");
		}

		$rdrp->setModel($r);

		$hdrp->js('change',$form->js()->atk4_form('reloadField','room_no',array($this->api->getDestinationURL(),'hostel_idx'=>$hdrp->js()->val())));      

		$form->addSubmit('Allot');

		if($form->isSubmitted()){

			// $form->js()->univ()->successMessage($form->get('rooms'))->execute();
			$ra=$this->add('Model_RoomAllotement');

			$ra['student_id']=$_GET['student_id'];
			$ra['room_id']=$form->get('room_no');
			$ra->save();
			$form->js()->univ()->closeExpander()->execute();
		}
	}
}

