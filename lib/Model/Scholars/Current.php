<?php

class Model_Scholars_Current extends Model_Scholar{

	function init(){
		parent::init();
        
        $st = $this->join('student.scholar_id');
        $st->hasOne('Class', 'class_id');
        $st->addField('ishostler')->type('boolean');
        $st->addField('isScholared')->type('boolean')->caption('Hostler As Scholared');
        $st->addField('bpl')->type('boolean')->caption('BPL');
        $st->hasOne('Sessions_Current', 'session_id');

        //$g = $st->join('scholar_guardian.scholar_id', null, 'left');
        $this->addCondition('session_id', $this->add('Model_Sessions_Current')->dsql()->field('id'));
        // $this->_dsql()->order(array('class_id','fname'));
        
	}
}