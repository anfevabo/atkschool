<?php
class Model_Staff extends Model_Table {
	var $table= "staff_master";
	function init(){
		parent::init();

		$this->addField('doj')->type('date')->mandatory("Required Field")->defaultValue(date('d-m-Y'))->caption('Date of Joining');
                $this->addField('ename')->mandatory("Name is Must")->caption('Name(English)');
                $this->addField('hname')->mandatory("Name is Must")->caption('Name(Hindi)')->display('hindi');
                $this->addField('designation')->mandatory("Designation is Must")->caption('Designation')->display('hindi');
                $this->addField('father_name')->mandatory("Required Field")->caption('Father`s Name/Husband`s Name')->display('hindi');
                $this->addField('mother_name')->mandatory("Required Field")->caption('Mother`s Name')->display('hindi');
                $this->addField('guardian_name')->caption('Eligiblity')->display('hindi');
                $this->addField('dob')->type('date')->mandatory("Required Field")->caption('Date of Birth');
                $this->addField('contact')->mandatory("Required Field");
                $this->addField('pan_no')->mandatory("Required Field");
                $this->add("filestore/Field_Image","image");//->type('image');//$this->add("filestore/Field_Image", "student_image"); 
                $this->addField('address')->type('Text')->mandatory("Required Field")->caption('Address')->display('hindi');
                $this->addField('sex')->display(array('form' => 'Radio'))->setValueList(array('Male','Female'))->defaultValue('M');
                $this->addField('accno')->caption('Bank Account Number');
                $this->addField('insurance_no')->caption('Insurance');
                $this->addField('ofhostel')->type('boolean')->caption("Hostel");
                $this->addField('remarks')->type('Text')->display('hindi');

                $this->hasMany('Staff_Movement','staff_id');

                $this->addExpression('name')->set('hname');
                $this->_dsql()->order('ename','asc');
                $this->addExpression('attendance_status')->set(function ($m,$q){
                        return $m->refSQL('Staff_Movement')->addCondition('session_id',$m->add('Model_Sessions_Current')->tryLoadAny()->get('id'))->_dsql()->del('field')->field('action')->limit(1)->order('id','desc');
                })->display('attendance');

                $fs=$this->leftJoin('filestore_file','image')
                        ->leftJoin('filestore_image.original_file_id')
                        ->leftJoin('filestore_file','thumb_file_id');
                $fs->addField('image_url','filename')->display(array('grid'=>'picture'));
	}
}