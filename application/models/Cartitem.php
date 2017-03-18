<?php

class Application_Model_Cartitem extends Zend_Db_Table_Abstract
{
    protected $_name  ='cartitem';

    function addProduct($userData)
    {
      $row= $this->createRow();
      $row->quantity=$userData['quantity'];
      $row->customer=$userData['custid'];
      $row->product=$userData['product'];

      $row->save();
    }

}
