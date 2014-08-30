<?php

class UserController extends Zend_Controller_Action
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
 
		
		if($this->_helper->checkAuthorized()) {  
		 	
			}  else { $this->_redirect("/user/login"); }
			
    }

    public function loginAction()
    {
        $userform = new Application_Form_Adduser();
		
		if($this->_request->isPost() && $userform->isValid($_POST)) {
			
			$data = $userform->getValues();
			$db = Zend_Db_Table::getDefaultAdapter();
			$authadapter = new Zend_Auth_Adapter_DbTable($db, 'users','username', 'password');
			$authadapter->setIdentity($data['username']);
			$authadapter->setCredential($data['password']);
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authadapter);
					
			
			if($result->isValid()) { $this->_redirect("/orders/"); } else { $this->view->message = "Login Failed."; }
			
		} 
		
		if($this->_helper->checkAuthorized()) {  
		 	$this->view->authorized = true; 
			}  else { 	
					$this->view->authorized = false;
					$userform->setAction('/user/login/');
					$userform->getElement('submit')->setLabel('Log In');
					$this->view->form = $userform;
				}
    }

    public function createAction()
    {
		$userform = new Application_Form_Adduser();
		
		if($this->_request->isPost()) {
			if($userform->isValid($_POST)) {
				$user = new Application_Model_User();
				$result = $user->createUser($userform->getValue('username'),$userform->getValue('password'),0);
				$this->view->Id = $result;
				$this->_forward('confirm', null, null, array('user' => $user));
				}
		}
		
	
		$userform->setAction('/user/create/');
		$userform->setAttrib('class','adduser-form');
		$this->view->form = $userform;
		
        $user = new Application_Model_User();
		//$result = $user->createUser("Maciek","haslo",0);
		//$this->view->Id = $result;
		//$this->_forward('confirm', null, null, array('user' => $user));
		
		
    }

    public function confirmAction()
    {
		$user = $this->getRequest()->getParam('user');
   		$this->view->user = $user;
		$result = $user->fetchAllUsers();
		var_dump($result[0]);
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_redirect("/user/");
    }


}









