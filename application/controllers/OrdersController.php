<?php

class OrdersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function preDispatch()
    {
	
		if(!$this->_helper->checkAuthorized())  
		 	 $this->_redirect("/user/login"); 
    }

    public function indexAction()
    {
    }

    public function lookupAction()
    {
		$this->_helper->layout()->disableLayout();
		if(!$this->_request->isXmlHttpRequest()) { 
			throw new Zend_Controller_Dispatcher_Exception('Invalid Request Type.'); 	
		}
		
		$validators = null;
		$filters = array(
    		'value'   =>	'StripTags',
			'method'  =>	'StripTags',
			'limit'	  =>	'StripTags', 
			'flag'	  =>	'StripTags' 
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		
		$this->view->inputString = $input->value;
		$this->view->method 	= $input->method;
		$this->view->limit 		= $input->limit;
		$this->view->flag		= $input->flag;
		
    }

    public function getDetailsAction()
    {
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
		if(!$this->_request->isXmlHttpRequest()) { 
			throw new Zend_Controller_Dispatcher_Exception('Invalid Request Type.'); 	
		}
		
		$validators = null;
		$filters = array(
    		'number'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		
		$order = new Application_Model_Order();
		$items = new Application_Model_Item(); 
		$items_rows = $items->getItems($input->number);
		$order->populate($input->number);
		$this->view->order = $order;
		$this->view->items = $items_rows;
		
		
		
		$string = $this->view->render("orders/get-details.phtml");
		
		$json = Zend_Json::encode(array(
        	'html' => $string,
        	'status' => $order->status["name"],
        	'number' => $order->number
    	 ));

    	echo $json;

			
		 
    }

    public function getStatusAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$status_obj = new Application_Model_Status();
		$status_obj->fetch($input->order, "number");
		
		
		$this->view->status_obj = $status_obj;
				
		$html_output = $this->view->render("orders/get-status.phtml");
		
		$json = Zend_Json::encode(array(
        	'html' => $html_output
    	 ));

    	echo $json;
    }

    public function getNotesAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();  
		
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$notes_obj = new Application_Model_Notes();
		$notes_obj->fetch($input->order, "number");
		
		
		$this->view->notes_obj = $notes_obj; 
		$html_output = $this->view->render("orders/get-notes.phtml");
		
		$json = Zend_Json::encode(array(
        	'html' => $html_output
    	 ));

    	echo $json; 		    
    }

    public function getShippingAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$shipping_obj = new Application_Model_Shipping();
		$quotes = $shipping_obj->getQuotes($input->order);
		$this->view->quotes = $quotes;
		
		$html_output = $this->view->render("orders/get-shipping.phtml");
		$json = Zend_Json::encode(array(
        	'html' => $html_output
    	 ));

    	echo $json; 	

    }

    public function activateQuoteAction()
    {
        // action body
    }

    public function getEmailActionsAction()
    {
        $this->_helper->layout()->disableLayout(); 
		$this->_helper->viewRenderer->setNoRender();        
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		$this->view->order = $input->order;
		$html_output = $this->view->render("orders/get-email-actions.phtml");
		$json = Zend_Json::encode(array(
        	'html' => $html_output
    	 ));

    	echo $json; 	
    }

    public function fetchOrdersAction()
    {
		$this->_helper->layout()->disableLayout(); 
        $of = new Application_Model_OrderFetcher();
		$of->fetchAll();
		
    }

    public function getItemsAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$items_obj = new Application_Model_Item();
		$items_rows = $items_obj->getItems($input->order);
		$this->view->items = $items_rows;
		
		$html_output = $this->view->render("orders/get-items.phtml");
		$json = Zend_Json::encode(array(
        	'html' => $html_output
    	 ));

    	echo $json; 	       
    }

    public function viewOriginalAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		$order_viewer = new Application_Model_OrderViewer();
		$original = $order_viewer->fetchOrder($input->order);
		$json = Zend_Json::encode(array(
        	'html' => $original
    	 ));

    	echo $json; 	       
    }

    public function getAddItemAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$items_obj = new Application_Model_Item();
		$items_rows = $items_obj->getItems($input->order);
		$this->view->items = $items_rows;
		
		$html = $this->view->render("orders/get-add-item.phtml");
		$json = Zend_Json::encode(array(
        	'html' => $html
    	 ));

    	echo $json; 
    }

    public function checkIpAction()
    {
       $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'order'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		if($input->order) {
			$ipchecker = new Application_Model_IpChecker();
			$ipchecker->order = $input->order;
			$return_array = $ipchecker->checkOrder($input->order);
			if($return_array["status"] != 1) {
				//return error
			}
			$this->view->required_data = $return_array;
			$html = $this->view->render("orders/check-ip.phtml");
    		echo $html; 			
			
		} else { 
			// return some error 
		}
		
		
    }

    public function getDropShipAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		//'items[]'   =>	'StripTags',
			'order' => 'StripTags'
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		
		$item_obj = new Application_Model_Item();
		$items = $item_obj->getItems($input->order);
		$this->view->items = $items;

		$html = $this->view->render("orders/get-drop-ship.phtml");
		$json = Zend_Json::encode(array(
        	'html' => $html
    	 ));

    	echo $json; 		
		//foreach($input->items as $item) {
		//	$item_obj->id = $item;
		//	$item_obj->getItem($this->_helper->getUsername());
		//	}
		//$json = Zend_Json::encode(array(
        //	'status' => "1"
    	// ));

    	//echo $json; 
    }


}



























