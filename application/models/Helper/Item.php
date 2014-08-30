<?php 

class Application_Model_Helper_Item { 
	
	public static function decodeStatus($status, $other = null) {
	
		switch($status) {
			
			case "1":
				return "Drop Shipped";
				break;
			case "2":
				return "No Stock";
				break;
			case "3": 
				return "Back Order";
				break;
			case "4":
				return "Removed";
				break;
			case "5":
				return "New Item";
				break;
			case "6":
				if($other != null) {
					$other_item = new Application_Model_Item();
					$other_row = $other_item->getItem($other);
					$other_name = $other_row->name;	
				}
				return "Replacement for $other_name";
				break;
			default: 
				return "Unknown";
				break;
		}
	}

}

?>