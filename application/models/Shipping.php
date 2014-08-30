<?php

class Application_Model_Shipping
{
	
	public static function addQuote($order, $type, $quote) { 
	
		$quote_adapter = new Application_Model_DbTable_ShippingQuotes();
		$quote_adapter->addQuote($order, $type, $quote);
		
	}
	
	public function getQuotes($order_number) {
		
		$quotes_adapter = new Application_Model_DbTable_ShippingQuotes();
		$all_quotes = $quotes_adapter->getQuotes($order_number);
		return $all_quotes;	
	}
	
	public static function removeQuote($id) { 
	
		$quote_adapter = new Application_Model_DbTable_ShippingQuotes();
		$quote_adapter->removeQuote($id);
		
	}
	
	public function getQuote($quote_id) {
		
	}
	
	public function setActiveQuote($id) {
		$quote_adapter = new Application_Model_DbTable_ShippingQuotes();
		$order_number = $quote_adapter->getQuote($id)->on;
		// reset active to 0 on all 
		$quote_adapter->clearActive($order_number);
		$quote_adapter->setActive($id);
		return $order_number;	
	}

	public function confirmShipping($quote_id) { 
		$quote_adapter = new Application_Model_DbTable_ShippingQuotes();
		$order_number = $quote_adapter->getQuote($quote_id)->on; 		

		$order_obj = new Application_Model_Order();
		$order_obj->number = $order_number;

		$order_obj->populate();
		$order_status = $order_obj->status["flag"];
		
		if( $order_status != "c") { 
			return 0; 
		} 
		
		$this->setActiveQuote($quote_id);
		$order_obj->setStatus("ce","Auto Email");
		return 1;
	}

}

