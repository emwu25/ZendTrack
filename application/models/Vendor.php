<?php

class Application_Model_Vendor
{
					// data keys for vendor: 
					//		email ->  	Vendors Email
					//		name -> 	Vendors Name
					// 		id -> 		Vendors Id. 
					
	
	private $data = array();
	
	public function __construct($id = null) {
		if($id)
		$this->getVendor($id);	
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
	
	public function getVendor($id)  { 
		$vendor_adapter = new Application_Model_DbTable_Vendors();
		$result = $vendor_adapter->getVendor($id);
		$this->id = $result->id;
		$this->name = $result->name;
		$this->email = $result->email;
		return $result;
	}

}

