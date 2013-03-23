<?php
class page_correction7 extends Page{
	function init(){
		parent::init();
		$this->query("UPDATE `fee_applicable` SET  `due`=`amount`;");	
		
		}
	function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }
}