<?php

class ShippingController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function preDispatch()
    {
	
		if(!$this->_helper->checkAuthorized())  
		 	 $this->_redirect("/user/login"); 
		$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function addQuoteAction()
    {
        $this->_helper->viewRenderer->setNoRender();  
		$validators = null;
		$filters = array(
    		'type'   =>	'StripTags',
			'order'  =>	'StripTags',
			'amount' => 'StripTags'
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();	   
	  			
		Application_Model_Shipping::addQuote($input->order,$input->type,$input->amount);
		$json = Zend_Json::encode(array(
        	'response' => "1"
    	 ));

    	echo $json;
    }

    public function removeQuoteAction()
    {
        $this->_helper->viewRenderer->setNoRender();  
		$validators = null;
		$filters = array(
    		'id'   =>	'StripTags'
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();	
		
		Application_Model_Shipping::removeQuote($input->id);
		$json = Zend_Json::encode(array(
        	'response' => "1"
    	 ));

    	echo $json;		
		  
    }

    public function activateQuoteAction()
    {
        $this->_helper->viewRenderer->setNoRender();  
		$validators = null;
		$filters = array(
    		'id'   =>	'StripTags'
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();	
		
		$shipping_obj = new Application_Model_Shipping(); 
		$shipping_obj->setActiveQuote($input->id);
		
		$json = Zend_Json::encode(array(
        	'response' => "1"
    	 ));

    	echo $json;	     
    }


}







