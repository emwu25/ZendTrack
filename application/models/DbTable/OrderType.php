<?php

class Application_Model_DbTable_OrderType extends Zend_Db_Table_Abstract
{

    protected $_name = 'order_type';
	
	public function addType($order_id, $order_type) {
	
		$row = $this->createRow();
		$row->order_id = $order_id;
		$row->order_type = $order_type;
		$row->save();	
	}
	
	public function getType($order_id) {
		$select = $this->select(); 
		$select->where('order_id = ?', $order_id);
		return $this->fetchRow($select);
	}


}

