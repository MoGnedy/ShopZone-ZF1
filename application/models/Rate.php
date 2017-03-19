<?php

class Application_Model_Rate extends Zend_Db_Table_Abstract
{
    protected $_name  ='rate';
    
    function addNewRate($newrate)
	{
       
	$row = $this->createRow();
	$row->customer = $newrate['customer'];
	$row->product = $newrate['product'];
	$row->rate = $newrate['star'];
	$row->save();
        
	}
}

