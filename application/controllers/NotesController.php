<?php

class NotesController extends Zend_Controller_Action
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

    public function addAction()
    {
        $this->_helper->viewRenderer->setNoRender();
		
        $notes_obj = new Application_Model_Notes();
		
		$validators = null;
		$filters = array(
    		'note'   =>	'StripTags',
			'order'  =>	'StripTags',
		);
		$data = $this->_request->getParams();
		
		$input = new Zend_Filter_Input($filters, $validators, $data);
		
		$input->isValid();
		$notes_obj->addNote($input->note,$input->order,$this->_helper->getUsername());
		
		$json = Zend_Json::encode(array(
        	'response' => "1"
    	 ));

    	echo $json; 		    
    }


}



