<?php
class page_correction7 extends Page{
	function init(){
		parent::init();
		$this->query("UPDATE `fee_applicable` SET  `due`=`amount`;");	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `extra_totals` VARCHAR( 255 ) NOT NULL");	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `column_code` VARCHAR( 255 ) NOT NULL ");	
		
		}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}