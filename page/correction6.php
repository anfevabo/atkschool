<?php
class page_correction5 extends Page{
	function init(){
		parent::init();
		$this->query("CREATE TABLE `main_block` (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`name` varchar( 255 ) NOT NULL ,
						`marksheet_designer_id` int( 11 ) NOT NULL ,
						`is_total_required` tinyint( 4 ) NOT NULL DEFAULT '0',
						PRIMARY KEY ( `id` )
					) ENGINE = InnoDB DEFAULT CHARSET = latin1;
					");	

		$this->query("CREATE TABLE `main_block` (
					`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
					`name` varchar( 255 ) NOT NULL ,
					`marksheet_designer_id` int( 11 ) NOT NULL ,
					`is_total_required` tinyint( 4 ) NOT NULL DEFAULT '0',
					PRIMARY KEY ( `id` )
					) ENGINE = InnoDB DEFAULT CHARSET = latin1;
					");
		$thhis->query("CREATE TABLE `marksheet_disgner` (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`class_id` int( 11 ) NOT NULL ,
						`name` varchar( 255 ) NOT NULL ,
						`session_id` int( 11 ) NOT NULL ,
						PRIMARY KEY ( `id` )
					) ENGINE = InnoDB DEFAULT CHARSET = latin1;
					");

		$this->query("ALTER TABLE `examsub_map` ADD `in_block` SMALLINT NOT NULL DEFAULT '1'");		
		$this->query("ALTER TABLE `main_block` ADD `total_title` VARCHAR( 100 ) NOT NULL DEFAULT 'Total'");		
		$this->query("ALTER TABLE `examsub_map` ADD `in_ms_row` SMALLINT NOT NULL DEFAULT '1'");
		// KHUSHBU :: master exam => associate subject =>markassign =>assign marksheet block (Give good names of buttons and add Marksheet row with block)
		// spaces in student_marks and fee applicable date field
		// fee_applicable and deposit due=aamount where due is null
	}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}