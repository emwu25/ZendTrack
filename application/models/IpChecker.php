<?php

class Application_Model_IpChecker
{
	
	//
	//
	//			$data array keys 
	//		
	//		order ->  Number of the order to verify. 
	//
	//
	
	private $data = array();

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
	  
	  public function checkOrder($order = null) {
		if ($order == null)  
	  		$order = $this->order;
			
		$order_obj = new Application_Model_Order();
		$order_obj->populate($order);
		
		$order_viewer = new Application_Model_OrderViewer(); 
		$original_order = $order_viewer->fetchOrder($order);
		
		$ip_addy = $this->getIpAddy($original_order);

		$geolocator = new Application_Model_Geolocation($ip_addy);
		$location_data = $geolocator->pullIpInfo();
		
		if(($status_code = (string)$location_data->statusCode) == "OK") {
			  
			  $return_array = array();
			  
			  $return_array["order"] = $order_obj;
			  $return_array["ip"] = $ip_addy;
			  $return_array["ip_city"] = $location_data->cityName;
			  $return_array["ip_zip"] = $location_data->zipCode;
			  $return_array["ip_long"] = $location_data->longitude;
			  $return_array["ip_latt"] = $location_data->latitude;
			  $return_array["status"] = 1;
			  
			  return $return_array;
			  
		}	else {
			
			 $return_array["status"] = 0; 
			 return $return_array;
			 
			// return some kind of error. 
		}
						
	  }
	  
	  private function getIpAddy($order_string) {
		preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $order_string, $matches); 
		return $matches[0];   
	  }

}

