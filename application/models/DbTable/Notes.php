<?php

class Application_Model_DbTable_Notes extends Zend_Db_Table_Abstract
{

    protected $_name = 'notes';

	public function fetch($lookup_data = null, $case = null, $id = null) {
			$select = $this->select();
			
			switch($case) {
			case "number":
				$select->where('notes.order = ?', $lookup_data);
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
	
	public function addNote($note, $order, $user){ 
		
		$row = $this->createRow();
		
		$row->note = $note;
		$row->order = $order;
		$row->user = $user;
		$id = $row->save();
	
	
	}
}

