<?php

class page_test extends Page {
	function page_index(){
		$form=$this->add('Form');
		$form->addField('upload','img')->setMode('plain');
		$form->addSubmit();

		$form->onSubmit(function($form){
			throw $form->exception("Opps")->setField('img');
			// $form->getElement('img')->saveInto('./upload/1.jpg');
			$form->js()->univ()->successMessage('sdsd')->execute();
		});

	}
}