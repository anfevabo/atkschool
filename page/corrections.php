<?php
class page_corrections extends Page {
	function init(){
		parent::init();

		// Create a few new tables
		$this->query("DROP TABLE IF EXISTS `diseases`;");
		$this->query("
				CREATE TABLE `diseases` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`name` varchar( 50 ) NOT NULL ,
					PRIMARY KEY ( `id` )
					) ENGINE = InnoDB DEFAULT CHARSET = latin1;
			");

		$this->query("DROP TABLE IF EXISTS `item_category`;");

		$this->query("
					CREATE TABLE `item_category` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`name` varchar( 100 ) NOT NULL ,
					PRIMARY KEY ( `id` )
					) ENGINE = InnoDB DEFAULT CHARSET = latin1;
			");

		$this->query("ALTER TABLE `item_master` ADD `category_id` INT NOT NULL ");

		// disease_master scholar_id to student_id and all id conversions
		// Change all Scholars ID to Student ID
		$this->query("ALTER TABLE `disease_master` CHANGE `scholar_id` `student_id` INT( 11 ) NOT NULL ");
		$with_scholar = $this->add('Model_Students_Disease');
		$this->query("ALTER TABLE `disease_master` ADD `disease_id` INT NOT NULL");

		foreach($with_scholar as $dis_tab){
			$s=$this->add('Model_Student');
			$s->addCondition('scholar_id',$dis_tab['student_id']);
			$s->tryLoadAny();
			$with_scholar['student_id'] = $s->id;
			$with_scholar->save();
		}

		// DONET NEED TO USE THIS CORRECTION. OLD DATA WAS CORRECT
		// $m=$this->add('Model_ExamClassSubjectMap');
		// $t=$this->add('Model_SubjectClassMap');
		// foreach($m as $junk){
		// 	$t->load($m['subject_id']);
		// 	$m['subject_id']=$t['subject_id'];
		// 	$m->save();
		// 	$t->unload();
		// }
 

	}

	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}