<?php

class Application_Model_Item
{
   private $data = array();
   
   			// 		keys to data array for item 
			//				id - >   id of the item in the database. 
			// 				status -> status of the item.
			//							1 - drop ship
			//							2 - No Stock
			//							3 - back order
			//							4 - removed 
			//							5 - new item 
			// 							6 - replacement for some other item 
			//							7 - reset status
			// 				name ->  item name;
			//				price -> item price
			//				desr -> item description
			//				order_number -> order number 
			//				other_item -> association to other item. by its id.

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
	
	public function addItem($user = null) {
		
		$items_adapter = new Application_Model_DbTable_Items();
		$id = $items_adapter->addItem($this->data["name"], $this->data["qty"],$this->data["price"], $this->data["desr"], $this->data["order_number"]);
		if($this->data["status"] != null) {
			$this->setStatus($user, $id, $this->data["status"], $this->data["other_item"]);
		}
	}
	
	// Returns rowcollection of items. 
	
	public function getItems($order_number) {
		$items_adapter = new Application_Model_DbTable_Items();
		$items_rows = $items_adapter->getItems($order_number); 						
		return $items_rows;
		
	}
	
	public function getStatus($item_id = null) {
		if($item_id == null) {
			$item_id = $this->data["item_id"];
		}
		$status_adapter = new Application_Model_DbTable_ItemStatus();
		return $status_adapter->getStatus($item_id);
	}
	
	public function setStatus($user ,$item_id = null, $status = null, $other = null) {
		if($item_id == null) {
			$item_id = $this->data["id"];
		}
		if($status == null) {
			$status = $this->data["status"];	
		}
		
		if($other == null) {
			$other = $this->data["other_item"];	
		}
		
	 	$status_adapter = new Application_Model_DbTable_ItemStatus();
		$status_adapter->setStatus($item_id, $status, $other);
		
		$my_item = $this->getItem($item_id);
		
		$note = new Application_Model_Notes();
		$text = "Item: ". $my_item->name ." status changed to " . Application_Model_Helper_Item::decodeStatus($status, $other).".";
		$note->addNote($text,$my_item->order_number,$user);	
	
	}
	
	public function getItem($item_id) {
		$item_adapter = new Application_Model_DbTable_Items();
		return $item_adapter->getItem($item_id);	
		
	}
	
	public function removeStatus($user, $item_id = null) {
		if($item_id == null) {
			$item_id = $this->data["id"];
		}
		$my_item = $this->getItem($item_id);
	 	$status_adapter = new Application_Model_DbTable_ItemStatus();
		$status_adapter->removeStatus($item_id);		
		$note = new Application_Model_Notes();
		$text = "Item: ". $my_item->name ." status reset.";
		$note->addNote($text,$my_item->order_number,$user);					
	}
	
	public function dropShipItem($user, $vendor) {
		$vendor_obj = new Application_Model_Vendor($vendor);
		$vendor_email = $vendor_obj->email;
		
		$email_obj = new Application_Model_Email();
		$email_obj->to = $vendor_email;
		$email_obj->subject = " Drop ship Request from 123dj.com"; 
		$email_obj->email_body = "This is a test sent to " . $vendor_obj->name; 
		$email_obj->sendTest();
		
		$note = new Application_Model_Notes();
		$text = "Drop Ship Request for: ". $this->name ." sent to  " . $vendor_obj->name .".";
		$note->addNote($text,$this->order_number,$user);
		
		$this->status = 1;
		$this->setStatus($user);	
	}

}

