<?php

class Application_Model_DbTable_ItemStatus extends Zend_Db_Table_Abstract
{

    protected $_name = 'item_status';

	public function getStatus($item_id) { 
		$select = $this->select();
		$select->where('item LIKE ?', $item_id);
		return $this->fetchRow($select);
	}
	
	public function setStatus($item_id, $status, $other = null) {
		
		$select = $this->select();
		$select->where('item LIKE ?', $item_id); 
		$row = $this->fetchRow($select);
		
		if(!$row) {
		$row = $this->createRow();
		$row->item = $item_id;	
		}
		
		$row->status = $status;
		if($other != null) 
		$row->other_item = $other;
		$row->save();			
	}
	
	public function removeStatus($item_id) {
		$where = $this->getAdapter()->quoteInto('item = ?', $item_id);
		$this->delete($where);	
	}

}

