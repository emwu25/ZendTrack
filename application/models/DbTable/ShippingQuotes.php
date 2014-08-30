<?php

class Application_Model_DbTable_ShippingQuotes extends Zend_Db_Table_Abstract
{

    protected $_name = 'shipping_quotes';


	public function addQuote($order_number, $type, $amount) {
		
		$row = $this->createRow();
		$row->on = $order_number;
		$row->quote = $amount;
		$row->type = $type;
		$id = $row->save();
		
	}

	public function getQuotes($order_number) { 
	
		$select = $this->select();
		$select->where('shipping_quotes.on = ?', $order_number);
		return $this->fetchAll($select);
		
	}
	
	public function removeQuote($id) { 
	
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->delete($where);
	
	}
	
	public function getQuote($id) {
		$select = $this->select();
		$select->where('shipping_quotes.id = ?', $id);
		return $this->fetchRow($select);	
	}
	
	public function setActive($id) { 
		  
		  $data = array(
				  'active'      => 1,
					  );	
		  $where = $this->getAdapter()->quoteInto('shipping_quotes.id = ?', $id);	
		  $this->update($data, $where);	
	}
	
	public function clearActive($order_number) { 
	
		  $where = $this->getAdapter()->quoteInto('shipping_quotes.on = ?', $order_number);
		  $data = array(
				  'active'      => 0,
					  );
		  $this->update($data, $where);	
	}

}

