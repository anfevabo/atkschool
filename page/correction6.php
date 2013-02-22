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
		
		// spaces in student_marks and fee applicable date field
		// fee_applicable and deposit due=aamount where due is null
	}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}