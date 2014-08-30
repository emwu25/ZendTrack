<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initInitHelpers() { 
		Zend_Controller_Action_HelperBroker::addPrefix('Tickets_Controller_Action_Helper');
	}
	
	protected function _initEmailSmtp() {
		
		$tr = new Zend_Mail_Transport_Smtp('mail.123dj.com');
		Zend_Mail::setDefaultTransport($tr);
	}


}

