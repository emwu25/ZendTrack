<?php

class SupportAccessController extends Zend_Controller_Action
{
    public function preDispatch()
    { 
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();   	
		// maybe some code to verify we're talking to suuport server in the future. 
		// for now i will verify per call. 
	}

    public function init()
    {
        /* Initialize action controller here */
    }


    public function confirmShippingAction()
    {
	 	$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		
		$quote_id = $input->quote;
		$secure = $input->sec;
		
		
		$computed_hash = Application_Model_Customer::computeConfirmHash($quote_id);
		
		if($computed_hash == $secure) {
			
			$shipping_obj = new Application_Model_Shipping();
			$result = $shipping_obj->confirmShipping($quote_id);
			
			echo $result;
		}		     
    		
			return 0;
	}


}



