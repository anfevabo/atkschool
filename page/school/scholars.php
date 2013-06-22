<?php

class page_school_scholars extends Page {
	function init(){
        parent::init();
            
        $acl=$this->add('xavoc_acl/Acl');
        $this->api->stickyGET('filter');
        $this->api->stickyGET('class');
        
        try{
        $form=$this->add('Form');
         $classs_field= $form->addField('dropdown','class')->setEmptyText('----')->setAttr('class','hindi');
        $c=$this->add('Model_Class');
        // $c->_dsql()->del('order')->order('class_id','asc');
        $classs_field->setModel($c);
        $form->addSubmit('Filter Class');





        $acl=$this->add('xavoc_acl/Acl');
        $crud=$this->add('CRUD',array('allow_del'=>false));
        // $scm=$this->add('Model_Scholars_Current');
        // $scm->_dsql()->del('order')->order('class_id','asc')->order('fname');

        $s=$this->add('Model_Student');
        $sc=$s->join('scholars_master.id','scholar_id');
        $sc->addField('admission_date')->type('date');
        $sc->addField('scholar_no');
        $sc->addField('sholar_father_name','father_name');
        $sc->addField('mother_name');
        $sc->addField('guardian_name');
        $sc->addField('dob')->type('date');
        $sc->addField('contact');
        $sc->addField('p_address')->type('text');
        $sc->addField('sex')->setValueList(array('M'=>'Male','F'=>'Female'));
        $sc->addField('isActive')->type('boolean');
        $sc->addField('category');
        $sc->addField('leaving_date')->type('date');
        $s->addCondition( 'session_id', $this->add( 'Model_Sessions_Current' )->tryLoadAny()->get( 'id' ) );
        

        if($_GET['filter']){
            if($_GET['class']) $s->addCondition('class_id',$_GET['class']);
        }
        else{
            $s->addCondition('class_id',-1);
        }


        if($crud->grid) $crud->grid->addColumn('sno','sno');
        
        $crud->setModel($s,array('admission_date','scholar_no','fname','name','sholar_father_name','mother_name'
                ,'guardian_name','dob','contact','student_image','p_address','sex','isActive',
               'leaving_date','category','class_id','ishostler','isScholared','bpl' ),array('fname','name','scholar_no','class','image_url'));

        $s->setOrder('fname','asc');
        if($form->isSubmitted()){
            $crud->grid->js()->reload(array(
                                            "class"=>$form->get('class'),
                                            "filter"=>-1

                ))->execute();

        }
        if($crud->grid){

            $crud->grid->addFormatter('class','hindi');
            $crud->grid->addQuickSearch(array('scholar_no','fname'));
             // $crud->grid->add("misc/Controller_AutoPaginator")->setLimit(50);
            $crud->grid->addPaginator();
        }
        if($crud->form){
            // make form flow in 2 columns
            // if($crud->form->model->loaded()){
            //     // $crud->form->getElement('class_id')->disable(true)->setFieldHint('You cannot edit class from here now');
            // }
            $crud->form->setFormClass('stacked atk-row');
            $o=$crud->form->add('Order')
                ->move($crud->form->addSeparator('noborder span6'),'first')
                ->move($crud->form->addSeparator('noborder span5'),'middle')
                ->now();
            
            // $crud->form->getElement('hname')->setAttr('class','hindi');
            $crud->form->getElement('sholar_father_name')->setAttr('class','hindi');
            $crud->form->getElement('mother_name')->setAttr('class','hindi');
            $crud->form->getElement('guardian_name')->setAttr('class','hindi');
            $crud->form->getElement('p_address')->setAttr('class','hindi');
            if($crud->form->hasElement('class_id')) $crud->form->getElement('class_id')->setAttr('class','hindi');
            // $crud->form->getElement('class_id')->setAttr('class','hindi');
//            $drp_cat=$crud->form->addField('dropdown','categary');
//            $cat=array("ST"=>"ST","SC"=>"SC","OBC"=>"OBC");
//            $drp_cat->setValueList($cat);
        }
    }catch(Exception $e){
        throw $e;
            $this->js()->univ()->errorMessage($e->getMessage())->execute();
            
        }


}
}