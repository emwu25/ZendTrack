<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

	public function addUser($username, $password, $flag) { 
	
		$row = $this->createRow();
		
		$row->username = $username;
		$row->password = $password;
		$row->flag = $flag;
		$id = $row->save();
		
		return $id;
	
	}
	
	public function fetchAllUsers() {
	
		$select = $this->select();	
		return $this->fetchAll($select);
	}


}

