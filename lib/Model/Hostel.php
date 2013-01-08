<?php

class Model_Hostel extends Model_Table{
	var $table="hostel_master";

	function init(){
		parent::init();

		$this->addField('name','building_name')->mandatory('Name is must');
		$this->hasMany('HostelRoom','hostel_id');

		$this->addExpression('Rooms')->set(function ($m,$q){
			return $m->refSQL('HostelRoom')->count();
		});

		$this->addExpression('capacity')->set(function ($m,$q){
			return $m->refSQL('HostelRoom')->sum('capacity');
		});

		$this->addExpression('alloted')->set(function ($m,$q){
			return $m->refSQL('HostelRoom')->dsql()->del('field')->field($q->dsql()->expr('sum((select count(*) from `hostel_allotement` where `hostel_allotement`.`room_id` = `rooms`.`id` ))'));
		});

		// $this->addExpression('alloted')->set(function ($m,$q){
		// 	$x= $m->refSQL('HostelRoom')->sum('');
		// 	echo $x;
		// 	return $x;
		// });

		  $this->addExpression("vacant")->set('building_name');//->display('diff');
		  $this->addHook('beforeSave',$this);
		  $this->addHook('beforeDelete',$this);

	}

	function beforeSave(){
		
		$this->add('Controller_Unique',array('unique_fields'=>
                            array(
                               'name'=>$this['name'],
                                )
                            )
                    );

	}

	function beforeDelete(){

		$h=$this->add('Model_HostelRoom');
		$h->addCondition('room_no',$this->id);
		if($h->count()->get() > 0)
			throw $this->exception("This Building has Room,cannot Delete ");
	}
}