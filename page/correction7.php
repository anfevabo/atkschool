<?php
class page_correction7 extends Page{
	function init(){
		parent::init();
		$q="
			ALTER TABLE `marksheet_sections` ADD `show_grade` TINYINT NOT NULL DEFAULT '1';
			
		";

		$this->query($q);	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `extra_totals` VARCHAR( 255 ) NOT NULL");	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `column_code` VARCHAR( 255 ) NOT NULL ");	
		
		}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}