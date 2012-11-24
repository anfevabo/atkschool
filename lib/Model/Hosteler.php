<?php

class Model_Hosteler extends Model_Student{

	function init(){
		parent::init();
		$this->addCondition('ishostler',true);
		$raj=$this->join('hostel_allotement.student_id','id');
		$rj=$raj->join('rooms.id','room_id');
		$bj=$rj->join('hostel_master.id','hostel_id');
		$rj->addField('room_no');
		$bj->addField('building_name');

		// $this->addExpression('attendence_status')->set(function ($m,$q){
		// 	// return $m->api->db->dsql()->table('hosteller_outward')
		// 	// 		->field('purpose')
		// 	// 		->where('scholar_id',$m->refSQL('scholar_id')->getField('id'))
		// 	// 		->limit(1)
		// 	// 		->order('id','desc');
		// 	return $m->refSQL('scholar_id/Students_Movement')->fieldQuery('purpose')->limit(1)->order('id','desc');
		// });
	}
}