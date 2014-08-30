<?php
class Application_Model_Helper_Order { 

	public static function decodeType($type) { 
	
		switch($type) { 
		
			case 1: 
				return "Credit Card Online";
			case 2:
				return "Money Order Online";
			case 3:
				return "PayPal Online";
			default: 
				return "Unknown Type";
		}
	
	}

}
?>