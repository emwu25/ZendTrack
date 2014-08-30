<?php

class Application_Model_Helper_Shipping {

	public static function decodeQuote($type) {
	
		switch($type) {
			
			case 1:
				return "FedEx Ground";
				break;
			case 2:
				return "FedEx Next Day Air";
				break;
			case 3:
				return "FedEx 2nd Day Air";
				break;
			case 4: 
				return "Freight";
				break;
			case 5: 
				return "Free Shipping";
				break;
			default: 
				return "Free Shipping";
				break;
		}
		
	}
	
}

?>