<?php

class ApplicationErrorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $errors = $this->_getParam('error_handler');
$exception = $errors->exception;
//Initialize view variables.
$this->view->exception = $exception;
    }


}

