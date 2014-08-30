<?php

class Application_Model_DbTable_LastFetched extends Zend_Db_Table_Abstract
{

    protected $_name = 'last_fetched';

	public function getLast() {
		
		$select = $this->select();	
		$select->limit = 1;
		$select->order("last_fetched.id desc");
		return $this->fetchRow($select);	
	}
	
	public function addLast($last_credit, $last_check, $last_paypal) { 
		$row = $this->createRow();
		$row->last_credit = $last_credit;
		$row->last_check = $last_check;
		$row->last_paypal = $last_paypal;
		$row->save();
	}
}

