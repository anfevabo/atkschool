<?php
class page_hostel_hostelallotement extends Page{
	function page_index(){

		$this->api->stickyGET('filter');
		$this->api->stickyGET('class');
		$form=$this->add('Form');
		$form->addField('dropdown','class')->setModel('Class');
		$form->addSubmit('Get List');
		
		$grid=$this->add('Grid');
		$s=$this->add('Model_Student');
		if($_GET['filter']){
			$s->addCondition('class_id',$_GET['class']);
		}


		$grid->setModel($s);
		$grid->addColumn('expander','alott','Allotement');
		$grid->addColumn('expander','deallot','De Allotement');
		$grid->addFormatter('scholar','hindi');
		$grid->addPaginator();

		if($form->isSubmitted()){
			$grid->js()->reload(array(
									"class"=>$form->get('class'),
									"filter"=>-1
								))->execute();
		}
	}

	
	function page_alott(){

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
		function page_deallot(){

			$this->api->stickyGET('student_id');
			$h=$this->add('Model_Hosteler');
			$h->tryLoad($_GET['student_id']);

			if(!$h->loaded()){
				$this->add('View_Info')->set('This is Not a Hostler');
				return;
			}
			$form=$this->add('Form');
			$form->add('View_Error')->set('Are you Sure?');
			$form->addSubmit('Delete');

			if($form->isSubmitted()){
				$ra=$this->add('Model_RoomAllotement');

				$ra->addCondition('session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
				$ra->addCondition('student_id',$_GET['student_id']);
				$ra->tryLoadAny();
				$ra->delete();
				$form->js()->univ()->closeExpander()->execute();
			}

		}
}

