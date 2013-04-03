<?php
class page_correction7 extends Page{
	function init(){
		parent::init();
		$q="
		SET FOREIGN_KEY_CHECKS=0;
		ALTER TABLE `marksheet_blocks_exam` ADD COLUMN `column_code`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `exammap_id`;
		ALTER TABLE `marksheet_blocks_exam` DROP COLUMN `max_marks`;
		ALTER TABLE `marksheet_section_blocks` ADD COLUMN `column_code`  varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `total_title`;
		ALTER TABLE `marksheet_sections` ADD COLUMN `extra_totals`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `grade_decider`;
		ALTER TABLE `marksheet_sections` ADD COLUMN `total_at_bottom`  tinyint(4) NOT NULL DEFAULT 1 AFTER `extra_totals`;
		SET FOREIGN_KEY_CHECKS=1;
		";

		$this->query($q);	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `extra_totals` VARCHAR( 255 ) NOT NULL");	
		// $this->query("ALTER TABLE `marksheet_sections` ADD `column_code` VARCHAR( 255 ) NOT NULL ");	
		
		}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}