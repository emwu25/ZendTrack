<?php

class Application_Model_User
{
	private $user_db_model; 
	
	public function __construct() {
       $this->user_db_model = new Application_Model_DbTable_Users();
   		
   }

	public function createUser($username, $password, $flag) {
		$result = $this->user_db_model->addUser($username,$password,$flag);
		return $result;
		
	}
	
	public function fetchAllUsers() { 
	
		return $this->user_db_model->fetchAllUsers(); 	
	
	}

}

