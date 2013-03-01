<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Session extends Model_Table{
    var $table='session_master';
    function init(){
        parent::init();

        $this->addField('name')->mandatory("Name of a session is must like [2011-2012]");
        $this->addField('iscurrent')->type('boolean')->defaultValue(false)->caption("Is current");
        $this->addField('start_date')->type('date')->caption("Session Start Date");
        $this->addField('end_date')->type('date')->caption("Session End Date");

        $this->hasMany('Student','session_id');       
        $this->hasMany('SubjectClassMap','session_id');
        $this->hasMany('RoomAllotement','session_id');       
        $this->hasMany('Item_Inward','session_id');       
        $this->hasMany('Item_Issue','session_id');       
        $this->hasMany('FeeClassMapping','session_id'); 
		$this->hasMany('ExamClassMap','session_id');       
        $this->hasMany('ExamClassSubjectMap','session_id');             
        $this->hasMany('Students_Attendance','session_id');             
        $this->hasMany('FeeClassMapping','session_id');             
        $this->hasMany('MarksheetDesigner','session_id');             
    }
    
    function markCurrent(){
        $this->dsql()->set('iscurrent',0)->do_update();
        $this->set('iscurrent',true)->update();
    }

}

