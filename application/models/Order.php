<?php

class Application_Model_Order
{
	private $order_db_connector; 
	// 					Order Information
	//
	//			keys for data
	//		id 		-> orders id in the database.  
	//		number -> order number
	// 		name -> customer first and last name
	// 		phone -> customer phone number
	// 		email -> customer email
	// 		date -> order placement date
	// 		address -> customer address
	// 		city -> customer city 
	//		state -> customer state
	// 		zip -> customer zip
	// 		instructions -> special instructions
	//		status -> order status			
	//		type ->  Type of the order 
	//						1  - Credit Card		
	//						2 - Check / Money Order
	//						3 - Paypal
	//						
	//		quotes[] -> array() of quotes for this order. 
	//						  -> quote["type"], quote["amount"], quote["id"]
	//
	//
	
	
	private $data = array();
	
	
	
	
	
	public function __construct() {
       $this->order_db_connector = new Application_Model_DbTable_Orders();
   		
   }
   
   public function  __get($name) {  
        // check if the named key exists in our array  
        if(array_key_exists($name, $this->data)) {  
            // then return the value from the array  
            return $this->data[$name];  
        }  
        return null;  
    } 
	
	public function  __set($name, $value) {  
        // use the property name as the array key  
        $this->data[$name] = $value;  
    }  
   
   //
   //	This will ideally return Zend_Db_Table_Row becasue it will use = for the comparison. 
   //
   //
   
   
   public function fetch($lookup_filter, $method, $limit, $flag = null) {
	 $order_row = $this->order_db_connector->fetch($lookup_filter, $method, $limit, $flag);
	 return $order_row;
	  
   }
   
   //
   //
   //	This function will set the status of the order. 
   //
   //
   public function setStatus($status, $user, $email_status = null, $text_status = null) {
		
		$response = array();
		
		$order_status = new Application_Model_Status();
		$order_status->setStatus($status,$this->data["number"],$user);
		$this->order_db_connector->setStatus($status, $this->data["number"]);
		$note = new Application_Model_Notes();
		$note->addNote(Application_Model_Helper_Notes::generateStatusChangeNote($status,$user),$this->data["number"],$user);
   		
   		if(($email_status == "true") && (Application_Model_Helper_Status::permittedEmails($status))) {

		  $returned_email = Application_Model_Helper_Status::getEmail($status, $this); 
		  
		  //print_r($returned_email);
		  
		  if($returned_email["error"] == true) {
			$response["error"] = $returned_email["error"];
			$response["msg"] = $returned_email["error_msg"];
			return $response;  
		  }
						 
		}
   }
   
 
   public function populate($order_number = null) {
	 if($order_number == null)
	 	$order_number = $this->number; 
		
	 $order_rows = $this->order_db_connector->fetch($order_number,"number",1);
	 $order_row = $order_rows->current();
	 
	 $this->data["id"] = $order_row->index;
	 $this->data["number"] =  $order_row->order_number;
	 $this->data["name"] = $order_row->last_name;
	 $this->data["phone"] = $order_row->customer_phone_number;
	 $this->data["email"] = $order_row->cust_email;
	 $this->data["date"] = $order_row->order_placed;
	 $this->data["address"] = $order_row->address;
	 $this->data["city"] = $order_row->city_state_zip;
	 $this->data["state"] = $order_row->State;
	 $this->data["zip"] = $order_row->zip;
	 $this->data["instructions"] = $order_row->special_info;
	 
	 $type_connector = new Application_Model_DbTable_OrderType();
	 $this->data["type"] = $type_connector->getType($this->data["id"])->order_type;
	 
	 // Determine the order status ( CAN BE REPLACED WITH THE CUSTOM HELPER ) 
	 
	 switch($order_row->flag) {
		case "pr":
			$this->data["status"] = array("flag" => "pr", "name"=>"Printed");
			break;
		case "c":
			$this->data["status"] = array("flag" => "c", "name"=>"Confirmation");
			break; 
		case "cp":
			$this->data["status"] = array("flag" => "cp", "name"=>"Confirmed (Phone)");
			break; 
		case "ce":
			$this->data["status"] = array("flag" => "ce", "name"=>"Confirmed (Email)");
			break; 
		case "ch":
			$this->data["status"] = array("flag" => "ch", "name"=>"Charged");
			break; 
		case "pd":
			$this->data["status"] = array("flag" => "pd", "name"=>"Processed");
			break; 
		case "sh":
			$this->data["status"] = array("flag" => "sh", "name"=>"Shipped");
			break; 
		case "nm":
			$this->data["status"] = array("flag" => "nm", "name"=>"No Match");
			break; 
		case "dc":
			$this->data["status"] = array("flag" => "dc", "name"=>"Declined");
			break; 
		case "ns":
			$this->data["status"] = array("flag" => "ns", "name"=>"No Stock");
			break; 
		case "ca":
			$this->data["status"] = array("flag" => "ca", "name"=>"Canceled");
			break; 
		case "cd":
			$this->data["status"] = array("flag" => "cd", "name"=>"Completed");
			break; 
		case "ds":
			$this->data["status"] = array("flag" => "ds", "name"=>"Matched");
			break; 
	 	case "p":
			$this->data["status"] = array("flag" => "p", "name"=>"Not Printed");
			break;
	    default:
			$this->data["status"] = array("flag" => "un", "name"=>"Unknown");
			break;			
	 }
	 
	    
   }
   		// This method will send email to email address listed on this order. 
		// Order needs to be populated prior to sending email. 
   
   public function sendEmail($subject, $body) { 
   
        $new_mail = new Application_Model_Email();
		$new_mail->to = $this->data["email"];
		$new_mail->subject = $subject;
		$new_mail->email_body = $body;
		$new_mail->sendTest();
   }
   
   public function addOrder() {
	 $order_id =  $this->order_db_connector->addOrder( $this->data["number"], $this->data["name"], $this->data["phone"],$this->data["email"], $this->data["date"], $this->data["address"], $this->data["city"], $this->data["state"], $this->data["zip"], $this->data["instructions"], $this->data["status"]);
   	 
	 $type_adapter = new Application_Model_DbTable_OrderType();
	 $type_adapter->addType($order_id, $this->data["type"]);
	
   }
   
   public function getShippingQuotes() { 
   			$this->data["quotes"] = array();
			$shipping_obj = new Application_Model_Shipping();
			$quote_rows = $shipping_obj->getQuotes($this->data["number"]);
			$number_of_quotes = 0;
			foreach($quote_rows as $key => $quote_row) {
				$this->data["quotes"][] = array("type" => $quote_row->type, "amount" => $quote_row->quote, "id" => $quote_row->id);
				$number_of_quotes++;
			}
			return $number_of_quotes;
   }
   
	public function getStatus() {
		// to do - get order status. 
	}
   
   
   
}

