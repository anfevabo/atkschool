<?php

class Model_Scholar extends Model_Table{
	var $table='scholars_master';
	
	function init(){
		parent::init();

        	$this->addField('admission_date')->type('date')->mandatory("Required Field")->defaultValue(date('d-m-Y'));
                $this->addField('scholar_no')->mandatory("Scholar Number is Must")  ;
                $this->addField('fname')->mandatory("Name is Must")->caption('Name(English)');
                $this->addField('hname')->mandatory("Name is Must")->caption('Name(Hindi)')->display('hindi');
                $this->addField('father_name')->mandatory("Required Field")->caption('Father`s Name');
                //$this->add("filestore/Field_Image","f_image")->caption('father Image');
                $this->addField('mother_name')->mandatory("Required Field")->caption('Mother`s Name');
                //$this->add("filestore/Field_Image","m_image")->caption('Mother Image');
                $this->addField('guardian_name');
                $this->addField('dob')->type('date')->mandatory("Required Field")->caption('Date of Birth');
                $this->addField('contact')->mandatory("Required Field");
                $this->add("filestore/Field_Image","student_image")->type('image');//$this->add("filestore/Field_Image", "student_image"); 
                $this->addField('p_address')->datatype('Text')->mandatory("Required Field")->caption('Permanent Address');
                $this->addField('sex')->setValueList(array('M'=>'Male','F'=>'Female'));
                $this->addField("isActive")->type('boolean')->mandatory("Is This Active")->defaultValue(true);
                $this->addField('leaving_date')->type('date')->defaultValue(null);
                $this->addField('category')->setValueList(array(null=>'Select Category', 'GEN'=>'GEN',"ST"=>"ST","SC"=>"SC","TAD"=>"TAD(ST)","OBC"=>"OBC","SOBC"=>"SPECIAL OBC","MINORITY"=>"MINORITY"));
                
                $this->hasMany('Student','scholar_id');
                $this->hasMany('Scholars_Guardian','scholar_id');
                $this->hasMany('Scholar','scholar_id');
                $this->hasMany('Students_Movement','scholar_id');
                $this->hasMany('Disease','scholar_id');

                $this->addExpression('name')->set('hname');
                $this->addExpression('Student_name')->set('fname');

                $fs=$this->join('filestore_file','student_image')
                        ->join('filestore_image.original_file_id')
                        ->join('filestore_file','thumb_file_id');
                $fs->addField('image_url','filename')->display(array('grid'=>'picture'));


	}
        
}