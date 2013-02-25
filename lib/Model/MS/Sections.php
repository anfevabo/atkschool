<?php
class Model_MS_Sections extends Model_Table{
	var $table = "marksheet_sections";

	function init(){
		parent::init();

		$this->addField("name")->caption("Section Name");
		$this->addField("has_grand_total")->type('boolean')->caption("Has Grand Total");
		
		$this->hasOne("MS_Designer","marksheet_designer_id");
		$this->hasMany("MS_SectionBlocks","marksheet_sections_id");
	}
}