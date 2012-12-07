<?php

class Model_Scholars_Current extends Model_Scholar{

	function init(){
		parent::init();
        
        // $st = $this->join('student.scholar_id');
        $q=$this->dsql();

        $st = $this->join('student.scholar_id',
                        $q->andExpr()->where('s.scholar_id',$q->getField('id'))->where('s.session_id',$this->add('Model_Sessions_Current')->tryLoadAny()->get('id'))
                        ,null,'s');
        $st->hasOne('Class', 'class_id');
        $st->addField('ishostler')->type('boolean');
        $st->addField('isScholared')->type('boolean')->caption('Hostler As Scholared');
        $st->addField('bpl')->type('boolean')->caption('BPL');
        $st->addField('roll_no');
        $st->hasOne('Sessions_Current', 'session_id');

        //$g = $st->join('scholar_guardian.scholar_id', null, 'left');
        // $this->addCondition('session_id', $this->add('Model_Sessions_Current')->tryLoadAny()->get('id'));
        // $this->_dsql()->order(array('class_id','fname'));
        
	}
}