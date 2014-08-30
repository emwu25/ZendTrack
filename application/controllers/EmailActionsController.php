<?php

class EmailActionsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		//$this->_helper->viewRenderer->setNoRender();
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
		
		switch($input->type) {
		
			case "nm":
				$this->_forward("send-no-match");
				break;
			case "dc":
				$this->_forward("send-decline");
				break;
			case "pd":
				$this->_forward("send-processed");
				break;
			case "c":
				$this->_forward("send-confirmation");
				break;
			default:
				break;
						
		
		}
    }

    public function preDispatch()
    {
		if(!$this->_helper->checkAuthorized())  
		 	 $this->_redirect("/user/login"); 
		$this->_helper->layout()->disableLayout();
    }

    public function sendNoMatchAction()
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
		
		$order = new Application_Model_Order();
		$order->populate($input->order);
		$this->view->order = $order;		
		$html = $this->view->render("email-actions/send-no-match.phtml");
		$order->sendEmail("No Match", $html);
		
		$note = new Application_Model_Notes();
		$note->addNote("No Match Email Sent", $input->order, $this->_helper->getUsername());
		
		$json = Zend_Json::encode(array(
        	'html' => $html,
			'action_status' => 1
    	 ));

        echo $json;
    }

    public function sendDeclineAction()
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
		
		$order = new Application_Model_Order();
		$order->populate($input->order);
		$this->view->order = $order;		
		$html = $this->view->render("email-actions/send-decline.phtml");
		$order->sendEmail("Card Declined", $html);
		
		$note = new Application_Model_Notes();
		$note->addNote("Declined Email Sent", $input->order, $this->_helper->getUsername());
		
		$json = Zend_Json::encode(array(
        	'html' => $html,
			'action_status' => 1
    	 ));

        echo $json;
    }

    public function sendProcessedAction()
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
		
		$order = new Application_Model_Order();
		$order->populate($input->order);
		$this->view->order = $order;		
		$html = $this->view->render("email-actions/send-processed.phtml");
		$order->sendEmail("Order Processed Successfully", $html);
		
		$note = new Application_Model_Notes();
		$note->addNote("Processed Email Sent", $input->order, $this->_helper->getUsername());
		
		$json = Zend_Json::encode(array(
        	'html' => $html,
			'action_status' => 1
    	 ));

        echo $json;
    }

    public function sendConfirmationAction()
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
		
		$order = new Application_Model_Order();
		$order->populate($input->order);
		$this->view->order = $order;
		$action_status = 0;
		$number_of_quotes = $order->getShippingQuotes();
		if($number_of_quotes) {				
			$html = $this->view->render("email-actions/send-confirmation.phtml");
			//$order->sendEmail("Shipping Charge Information", $html);
		
			$note = new Application_Model_Notes();
			//$note->addNote("Confirmation Email Sent", $input->order, $this->_helper->getUsername());
			$action_status = 1;
		}
		echo $html;
		$json = Zend_Json::encode(array(
        	'html' => $html,
			'action_status' => $action_status
    	 ));

        //echo $json;
    }


}









