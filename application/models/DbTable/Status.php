<?php

class Application_Model_DbTable_Status extends Zend_Db_Table_Abstract
{

    protected $_name = 'status';
	
	
	public function fetch($lookup_data = null, $case = null, $id = null) {
		$select = $this->select();
		
		switch($case) {
		case "number":
			$select->where('status.order = ?', $lookup_data);
			break;
		case "user":
			$select->where('user = ?', $lookup_data);			
			break;
		default: 
			break;
		}
		if($id)
			$select->where('id = ?', $flag);
		
		$select->order("id asc");
		
		return $this->fetchAll($select);
			
	}
	
	public function setStatus($status, $order, $user){ 
		
		$row = $this->createRow();
		
		$row->status = $status;
		$row->order = $order;
		$row->user = $user;
		$id = $row->save();
	
	
	}

}

