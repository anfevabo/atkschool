<?php
class page_store_reciept extends Page{
  function init(){
    parent::init();
      $this->api->stickyGET('month');
      $this->api->stickyGET('store_no');

      $this->add('View_Receipt',array('store_no'=>$_GET['store_no'],'month'=>$_GET['month']));

  }
}