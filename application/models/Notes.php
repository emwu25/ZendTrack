<?php

class Application_Model_Notes
{
	private $data = array();
	private $notes_db_connector;
	
	
	public function __construct() {
       $this->notes_db_connector = new Application_Model_DbTable_Notes();
   		
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
	
	
	
	public function fetch($data = null, $case = null, $id = null) {
		
		$status_rowset = $this->notes_db_connector->fetch($data, $case, $id);
		
		
		
		foreach($status_rowset as $each_row) { 
			
			$single_note_array = array("id" => $each_row->id, "note" => $each_row->note, "order"=>$each_row->order,"user" => $each_row->user, "date"=>$each_row->note_date);
			$this->data["notes_collection"][] = $single_note_array;
		}
	}
	
	public function  addNote($note, $order, $user) {
		$this->notes_db_connector->addNote($note, $order, $user);
		
	}

}

