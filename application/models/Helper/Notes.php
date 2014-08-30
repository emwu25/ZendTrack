<?php

class Application_Model_Helper_Notes { 

	public static function generateStatusChangeNote($status, $user) {
		 
		 		 
		 switch($status) {
			case "pr":
				 $string = "Status changed to Printed by ";
				break;
			case "c":
				$string = "Status changed to Confirmation by ";
				break; 
			case "cp":
				$string =  "Status changed to Confirmed (Phone) by ";
				break; 
			case "ce":
				$string =  "Status changed to Confirmed (Email) by ";
				break; 
			case "ch":
				$string =  "Status changed to Charged by ";
				break; 
			case "pd":
				$string =  "Status changed to Processed by ";
				break; 
			case "sh":
				$string =  "Status changed to Shipped by ";
				break; 
			case "nm":
				$string =  "Status changed to No Match by ";
				break; 
			case "dc":
				$string =  "Status changed to Declined by ";
				break; 
			case "ns":
				$string =  "Status changed to No Stock by ";
				break; 
			case "ca":
				$string =  "Status changed to Canceled by ";
				break; 
			case "cd":
				$string =  "Status changed to Completed by ";
				break; 
			case "ds":
				$string =  "Status changed to Matched by ";
				break; 
			case "p":
				$string =  "Status changed to Not Printed by ";
				break;
			default:
				$string =  "Status changed to Unknown by ";
				break;			
		 }
		 
		 $string = $string .''. $user;
		 return $string;
	}
	
}
?>
