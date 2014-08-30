<?php

class Application_Model_Geolocation
{

	private $is_data_pulled = false;
	private $api_key = "";
	private $ip_address = "";
	private $city = "";
	private $area_code = "";
	private $zip = "";

	

	function __construct($ip_arg) {
	   $this->ip_address = $ip_arg;
   }
   
   function pullIPInfo() { 
   		$query_string = "http://api.ipinfodb.com/v3/ip-city/?key=$this->api_key&ip=$this->ip_address&format=xml";
		$d = file_get_contents($query_string);
		
		$enc = mb_detect_encoding($d);
		$d = mb_convert_encoding($d, 'UTF-8', $enc);
		$answer = new SimpleXMLElement($d);
		
		//print_r($answer);
		return $answer;
   
   }

}

