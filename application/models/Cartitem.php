<?php
use Zend\Db\Sql\Sql;
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
    function listcartitems()
    {
      return $this->fetchAll()->toArray();
    }
    function selectprice($prdid)
    {

      $product = new Application_Model_Product();
      $row = $product->fetchRow($product->select()->where('id = ?', $prdid)
                                                  ->where());

      // Get the column/value associative array from the Row object
      $rowArray = $row->toArray();

      // Now use it as a normal array
      foreach ($rowArray as $column => $value) {
          if ($column =='price') {
            return $value;
          }
      }
    }

      function selectoffer($id)
      {
        $sql=$this->select()
        ->from(array('c' => 'cartitem'), array('quantity'))
               ->join(array('p' => 'product'), 'p.id=c.customer', array('name','price'))
               ->join(array('o' => 'offer'), 'p.offer=o.id', array('offer_per'))
               ->where('c.customer = ?', $id)
        ->setIntegrityCheck(false);
        $query=$sql->query();
        $result=$query->fetchAll();
        return $result;
      }

}
