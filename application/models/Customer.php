<?php

class Application_Model_Customer
{


	public static function computeConfirmHash($quote_id) {
			
			$hash =  $quote_id . md5(SALT);
			$double = md5($hash);
		
		return $double; 
	}

}

