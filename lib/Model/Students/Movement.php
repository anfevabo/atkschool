<?php
class Model_Students_Movement extends Model_Table{
	var $table="hosteller_outward";
	function init(){
		parent::init();

		$this->hasOne('Students_Current','student_id');
		$this->hasOne('Scholars_Guardian','gaurdian_id');
		$this->addField('date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('purpose')->enum(array('inward','outward','enquiry'))->mandatory('Purpose must be selected');
		$this->addField('remark');
		$this->addField('direction');

		$this->_dsql()->order('id','desc');
	}
}