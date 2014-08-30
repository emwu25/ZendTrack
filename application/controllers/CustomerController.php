<?php

//
//
//		THIS FILE SHOULD BE ON HELPER SERVER.
//
//

class CustomerController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function preDispatch()
    { 
		$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function confirmShippingAction()
    {
       	$this->_helper->viewRenderer->setNoRender();
		if(!$this->_request->isXmlHttpRequest()) { 
		//	throw new Zend_Controller_Dispatcher_Exception('Invalid Request Type.'); 	
		}
		
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		
		$quote_id = $input->quote;
		$secure = $input->sec;
				
		if(file_get_contents(MY_HOSTNAME . "/support-access/confirm-shipping/quote/" . $quote_id . "/sec/" . $secure)) {
			 header( 'Location: http://www.123dj.com/order-confirmed/' ) ;

		} else { 
			 header( 'Location: http://www.123dj.com/order-not-confirmed/' ) ;
		}
	
	}



}



