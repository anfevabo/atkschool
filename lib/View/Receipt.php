<?php
class View_Receipt extends View {
	public $store_no;
	public $month;
	public $grid;

	function init(){
		parent::init();
		$st=$this->add('Model_Hosteler');
		$st->addCondition('store_no',$this->store_no);
		$st->tryLoadAny();
		$sc=$st->ref('scholar_id');
		$this->template->trySet('student_name',$st['name']);
		$this->template->trySet('father_name',$sc['father_name']);
		$this->template->trySet('class_name',$st->ref('class_id')->get('name'));

		$this->grid=$this->add('Grid');
		$ism = $st->ref('Item_Issue');
		$ism->addExpression('date_month')->set('Month(date)');
		$ism->addCondition('date_month',$_GET['month']);
		$ism->addExpression('total_qty')->set('sum(quantity)');
		$ism->addExpression('total_amount')->set('sum(quantity * rate)');
		$ism->_dsql()->group('item_id')->group('rate');

		// $ism->debug();
		$this->grid->setModel($ism,array('item','total_qty','rate','total_amount'));
		$this->grid->addFormatter('item','hindi');
		$this->grid->setFormatter('total_amount','money');
		$this->grid->setFormatter('total_qty','number');

		$this->grid->addTotals(array('total_qty', 'total_amount'));

		$this->api->welcome->destroy();


	}

	function defaultTemplate(){
		return array('view/receipt');
	}

	function render(){
		$this->api->template->del('logo');
		$this->api->template->del('Menu');

		parent::render();
	}
}