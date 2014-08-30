<?php 


class Zend_View_Helper_GetIdentity extends Zend_View_Helper_Abstract { 

	public function getIdentity() { 
	
	
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			return $auth->getIdentity();
				
		}
		
		return null; 
	
	}
}


?>
