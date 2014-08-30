<?php

class Application_Model_DbTable_Orders extends Zend_Db_Table_Abstract
{

    protected $_name = 'customer_info';
	
//	public function addUser($username, $password, $flag) { 
//	
//		$row = $this->createRow();
//		
//		$row->username = $username;
//		$row->password = $password;
//		$row->flag = $flag;
//		$id = $row->save();
//		
//		return $id;
//	
//	}
	
	public function getAll() {
	
		$select = $this->select();	
		return $this->fetchAll($select);
	}
	
	public function fetch($lookup_data, $case, $limit = null, $flag = null) {
		$select = $this->select();
		$lookup_like = '%'.$lookup_data.'%';
		
		switch($case) {
		case "number":
			$select->where('order_number LIKE ?', $lookup_like);
			break;
		case "name":
			$select->where('last_name LIKE ?', $lookup_like);			
			break;
		case "email":
			$select->where('cust_email LIKE ?', $lookup_like);			
			break;
		case "phone":
			$select->where('customer_phone_number LIKE ?', $lookup_like);			
			break;
		default: 
			break;
		}
		if($flag)
			$select->where('flag = ?', $flag);
		
		$select->order("index desc");
		if($limit != null) { 
			$select->limit($limit);
		}
		
		return $this->fetchAll($select);
			
	}
	
	public function setStatus($status, $number) {
	
			$data = array(
			'flag'      => $status,
				);
				 
		$where = $this->getAdapter()->quoteInto('order_number = ?', $number);
				 
		$this->update($data, $where);
	
		
	}
	
	public function addOrder($order_number, $name, $phone, $email, $date, $address, $city, $state, $zip, $instructions, $status) {
		$row = $this->createRow();
		
		$row->order_number = $order_number; 
		$row->last_name = $name;
		$row->customer_phone_number = $phone;
		$row->cust_email = $email;
		$row->order_placed = $date;
		$row->address = $address;
		$row->city_state_zip = $city;
		$row->State = $state;
		$row->zip = $zip;
		$row->special_info = $instructions;
		$row->flag = $status;
		$id = $row->save();
		return $id;
	}
} 

