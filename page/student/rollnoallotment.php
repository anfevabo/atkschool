<?php
class page_student_rollnoallotment extends Page{
	function page_index(){
		$form=$this->add('Form',null,null,array('form_horizonatal'));
		$class_field=$this->addField('dropdown','class');


	}
}