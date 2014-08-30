<?php

class Application_Model_DbTable_Vendors extends Zend_Db_Table_Abstract
{

    protected $_name = 'vendors';


	public function getVendor($id) {
	$select	= $this->select();
	$select->where('vendors.id = ?', $id);
	return $this->fetchRow($select);
	}
}

