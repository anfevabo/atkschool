<?php

class Model_Hostel_StudentGuardian extends  Model_Table
{
    
    var $table='scholar_guardian';
    function init()
    {
        parent::init();
      // $s= $this->join('scholars_master','scholar_id');
       // $s->addField('fname');
        $this->addField('scholar_id');
        $this->addField('gname')->caption('Guardian');
        $this->addExpression('Guardian')->set('gname');
        $this->add("filestore/Field_Image","image");
        $this->addField('relation');
        $this->addField('contact');
        $this->addField('address');
               
//$this->hasOne('Scholar','scholar_id');
    }
} 