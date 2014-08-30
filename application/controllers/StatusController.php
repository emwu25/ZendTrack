<?php

class StatusController extends Zend_Controller_Action
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
        $status_obj = new Application_Model_Status();
		$status_obj->fetch();
		
		foreach($status_obj->status_collection as $status) {
			echo "<br>" . $status["time_set"] ;	
		}
    }

    public function setAction()
    {
		$this->_helper->viewRenderer->setNoRender();
		$email = null;				// Initialize email and sms to null.  We will pass them depending on the values passed in the rquest. 
		$sms = null;
        $order_obj = new Application_Model_Order();
		$validators = null;
		$filters = array(
    		'status'   =>	'StripTags',
			'order'  =>	'StripTags',
			'email' => 'StripTags',
			'sms' => 'StripTags'
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		
		$order_obj->populate($input->order);		
		$response = $order_obj->setStatus($input->status,$this->_helper->getUsername(),$input->email, $input->sms);
		
		$json = Zend_Json::encode(array(
        	'status' => Application_Model_Helper_Status::decode($input->status), // doesnt check anything just returns the requested status. 
        	'number' => $input->order,
			'error' => $response["error"],
			'msg' => $response["msg"]
    	 ));

    	echo $json;
    }


}



