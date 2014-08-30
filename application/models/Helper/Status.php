<?php

class Application_Model_Helper_Status { 

	public static function decode($status) {
		 
		 switch($status) {
			case "pr":
				 return "Printed";
				break;
			case "c":
				return "Confirmation";
				break; 
			case "cp":
				return "Confirmed (Phone)";
				break; 
			case "ce":
				return "Confirmed (Email)";
				break; 
			case "ch":
				return "Charged";
				break; 
			case "pd":
				return "Processed";
				break; 
			case "sh":
				return "Shipped";
				break; 
			case "nm":
				return "No Match";
				break; 
			case "dc":
				return "Declined";
				break; 
			case "ns":
				return "No Stock";
				break; 
			case "ca":
				return "Canceled";
				break; 
			case "cd":
				return "Completed";
				break; 
			case "ds":
				return "Matched";
				break; 
			case "p":
				return "Not Printed";
				break;
			default:
				return "Unknown";
				break;			
		 }
	}
	
	public static function permittedEmails($status) {
		 
		 switch($status) {
			case "pr":
				 return false;
				break;
			case "c":
				return true;
				break; 
			case "cp":
				return false;
				break; 
			case "ce":
				return false;
				break; 
			case "ch":
				return false;
				break; 
			case "pd":
				return true;
				break; 
			case "sh":
				return true;
				break; 
			case "nm":
				return true;
				break; 
			case "dc":
				return true;
				break; 
			case "ns":
				return true;
				break; 
			case "ca":
				return true;
				break; 
			case "cd":
				return false;
				break; 
			case "ds":
				return false;
				break; 
			case "p":
				return false;
				break;
			default:
				return false;
				break;			
		 }		
	}
	
	public static function getEmail($status, $order) { 
		$view = new Zend_View();
		$view->addScriptPath( APPLICATION_PATH ."/views/scripts/");
		$view->order = $order;
		$return_array; 
		
		$view->render("email-actions/send-processed.phtml");
		 
		 switch($status) {
			case "c":
				if($order->getShippingQuotes() == 0) {
				$return_array = array("html" => $view->render("email-actions/send-processed.phtml"), "error" => true, "error_msg" => "Can not send confirmation without existing quotes. Please add shipping quotes and send confirmation email from emails action tab."); /// this needs to be adjusted for the confirmation email.
				} else {
				$return_array = array("html" => $view->render("email-actions/send-processed.phtml"), "error" => false, "error_msg" => "This order has quotes. We can Email it."); /// this needs to be adjusted for the confirmation email.		
				}
				break; 
			case "pd":
				$return_array = array("html" => $view->render("email-actions/send-processed.phtml"), "error" => false, "error_msg" => "");
				break; 
			case "sh":
				$return_array = array("html" => "Shipped", "error" => true, "error_msg" => "This email does not exist yet."); // this email does not exists yet. 
				break; 
			case "nm":
				$return_array = array("html" => $view->render("email-actions/send-no-match.phtml"), "error" => false, "error_msg" => "");
				break; 
			case "dc":
				$return_array = array("html" => $view->render("email-actions/send-decline.phtml"), "error" => false, "error_msg" => "");
				break; 
			case "ns":
				$return_array = array("html" => "No Stock", "error" => true, "error_msg" => "This email does not exists yet.");
				break; 
			case "ca":
				$return_array = array("html" => "Canceled", "error" => true, "error_msg" => "This email does not exists yet.");
				break; 
			default:
				$return_array = array("html" => "", "error" => true, "error_msg" => "Unknown status. Cant send email.");
				break;			
		 }	
		 
		 return $return_array;	
		
	}
	
}
?>
