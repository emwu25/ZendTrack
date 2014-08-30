<?php

class Application_Model_Status
{
	private $status_db_connector; 
	private $data = array();

	public function __construct() {
       $this->status_db_connector = new Application_Model_DbTable_Status();
   		
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
	//
	//		Fetch rowset with all rows for given order / user. 
	//
	//
	
	public function fetch($data = null, $case = null, $id = null) {
		
		$status_rowset = $this->status_db_connector->fetch($data, $case, $id);
		
		
		
		foreach($status_rowset as $each_row) { 
			
			$single_status_array = array("id" => $each_row->id, "status" => $each_row->status, "order"=>$each_row->order,"user" => $each_row->user, "time_set"=>$each_row->time);
			$this->data["status_collection"][] = $single_status_array;
		}
		
		//var_dump($this->data);
	
	}
	
	//
	//
	//		Create new status for the row.  
	//	
	//
	
	public function setStatus($status,$order,$user) {
		$this->status_db_connector->setStatus($status,$order,$user);
	}		

}

