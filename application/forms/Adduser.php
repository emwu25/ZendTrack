<?php

class Application_Form_Adduser extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');
	   
	   $this->setDecorators(array(
	   'FormElements',
	    array('HtmlTag', array('tag' => 'dl', 'class' => 'login-form')),
	   'Form'
	    ));
	   
	   
	   
	   
	   // Elements 
	   
	   $username = $this->createElement('text','username');
	   $username->setLabel("Username:");
	   $username->setRequired();
	   $username->addFilter('StripTags');
	   $username->addErrorMessage('Username Required!');					 
	   $username->addDecorator(array('Wrapper' => 'HtmlTag'), array('tag'=>'div', 'class' => 'form-row'));	   
	   $this->addElement($username);
	   
	   
	   $password = $this->createElement('password','password');
	   $password->setLabel("Password:");
	   $password->setRequired();	   
	   $password->addDecorator(array('Wrapper' => 'HtmlTag'), array('tag'=>'div', 'class' => 'form-row'));	   
	   $this->addElement($username);

	   $this->addElement($password);
	   
	   $submit = $this->createElement('submit','submit');
	   $submit->setLabel("Create Account");
	   $submit->addDecorator(array('Wrapper' => 'HtmlTag'), array('tag'=>'div', 'class' => 'form-row'));	 
	   $this->addElement($submit);
	   

	   
	   
	   
    }


}

