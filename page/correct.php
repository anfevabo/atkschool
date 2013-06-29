<?php

class page_correct extends Page {
	function init(){
		parent::init();

		$this->query('ALTER TABLE `marksheet_designer` ADD `declare_date` DATETIME NOT NULL ');
		$this->query('DROP TABLE IF EXISTS `grade_master` ;
						CREATE TABLE `grade_master` (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`percent_above` int( 11 ) NOT NULL ,
						`name` varchar( 1 ) NOT NULL ,
						`session_id` int( 11 ) NOT NULL ,
						PRIMARY KEY ( `id` )
						) ENGINE = InnoDB DEFAULT CHARSET = latin1;');
		$this->query('ALTER TABLE `student` ADD `result_stopped` TINYINT NOT NULL ');
		$this->query(" ALTER TABLE `fee` ADD `for_hostler_only` TINYINT NOT NULL AFTER `scholaredamount` ");
		$this->query("  ALTER TABLE `fee_deposit_master` CHANGE `remarks` `remarks` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");


		// SECOND FILE CORRECTIONS ....
		$this->query('ALTER TABLE `hosteller_outward` ADD `session_id` INT NOT NULL ');
		$this->query('UPDATE `hosteller_outward` SET `session_id`=8');




	}

	function query($q){

	}
}