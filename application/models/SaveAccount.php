<?php
/**
* Model - Save the data into the DB.
* This code base can be used in other applications that need
* data to be stored for new users.
*
**/
class SaveAccount {
/**
* Save Account
*
* @param String $username
* @param String $password
* @param String $email
*/
public function saveAccount($username, $password, $email){
	//Clean up data
	$username = $this->_db->escape($username);
	$password = $this->_db->escape($password);
	$email = $this->_db->escape($email);
	
	echo $email;

}
}
