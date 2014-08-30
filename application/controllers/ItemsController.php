<?php

class ItemsController extends Zend_Controller_Action
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
        // action body
    }

    public function setNoStockAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'items[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		
		$item_obj = new Application_Model_Item();
		
		foreach($input->items as $item) {
			$item_obj->id = $item;
			$item_obj->status = 2;
			$item_obj->setStatus($this->_helper->getUsername());
			}
		$json = Zend_Json::encode(array(
        	'status' => "1"
    	 ));

    	echo $json; 
    }

    public function addAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'data[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		//var_dump($input->data);
		
		$item_obj = new Application_Model_Item();
		$item_obj->name = $input->data["name"];
		$item_obj->qty = $input->data["qty"];
		$item_obj->price = $input->data["price"];
		$item_obj->desr = "Manually entered Item";
		$item_obj->status = $input->data["status"];
		$item_obj->other_item = $input->data["other_item"];
		$item_obj->order_number = $input->data["order"];
		$item_obj->addItem($this->_helper->getUsername());
				
    }

    public function setBackOrderAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'items[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		
		$item_obj = new Application_Model_Item();
		
		foreach($input->items as $item) {
			$item_obj->id = $item;
			$item_obj->status = 3;
			$item_obj->setStatus($this->_helper->getUsername());
			}
		$json = Zend_Json::encode(array(
        	'status' => "1"
    	 ));

    	echo $json; 
    }

    public function setRemovedAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'items[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		
		$item_obj = new Application_Model_Item();
		
		foreach($input->items as $item) {
			$item_obj->id = $item;
			$item_obj->status = 4;
			$item_obj->setStatus($this->_helper->getUsername());
			}
		$json = Zend_Json::encode(array(
        	'status' => "1"
    	 ));

    	echo $json; 
    }

    public function removeStatusAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'items[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		
		$item_obj = new Application_Model_Item();
		
		foreach($input->items as $item) {
			$item_obj->id = $item;
			$item_obj->removeStatus($this->_helper->getUsername());
			}
		$json = Zend_Json::encode(array(
        	'status' => "1"
    	 ));

    	echo $json; 
    }

    public function dropShipAction()
    {
        $this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'items[]'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		foreach ($input->items as $item) {
			$item_obj = new Application_Model_Item();
			$item_obj->name = $item["name"];
			$item_obj->order_number = $item["order"];
			$item_obj->id = $item["id"];
			$item_obj->dropShipItem($this->_helper->getUsername(), $item["vendor"]);	
		}
    }


}













