<?php

class Application_Model_DbTable_Items extends Zend_Db_Table_Abstract
{

    protected $_name = 'order_items';

	public function addItem($name, $qty, $price, $descr, $order_number) {
		
	 	$row = $this->createRow();
		$row->name = $name;
		$row->qty = $qty;
		$row->price = $price;
		$row->description = $descr;
		$row->order_number = $order_number;
		return $row->save();	
	}
	
	public function getItems($order_number) { 
		$select = $this->select();
		$select->from(array('order_items'));
		$select->joinLeft('item_status', "order_items.id = item_status.item", array("item_status.status", "item_status.other_item"));
		$select->setIntegrityCheck(false); 
		$select->where('order_items.order_number LIKE ?', $order_number);
		return $this->fetchAll($select);
	}
	
	public function getItem($item_id) { 
		$select = $this->select(); 
		$select->where('order_items.id = ?', $item_id);
		return $this->fetchRow($select);
		
		
	}
}

