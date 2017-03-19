<?php

class Application_Model_Wishlist extends Zend_Db_Table_Abstract
{
    protected $_name  ='wishlist';
     public function SelectionWishList($Wish_id)
    {
    	$sql=$this->select()
    	->from(array('w'=>"wishlist"))
    	->joinInner(array("cu"=>"customer"), "w.customer_id=cu.id",array("name as customer_name"))
    	->joinInner(array("p"=>"product"), "p.id=w.product_id",array("name as product_name"))
    	->where("w.id=$Wish_id")
    	->setIntegrityCheck(false);
    	$query=$sql->query();
    	// echo $sql->__toString();
    	// die();
    	$result=$query->fetchAll();
  
    	return $result;

    	

    }


 public function deleteWish($id)
{
	//pass param prod and id
	//check empty and how to delete row
	
	
	$this->delete("id=$id");

}


public function AddToWishList($test)
{

  $row=$this->createRow();         
  $row->customer_id=$test[1];  
  $row->product_id=$test[0];
  $row->save();
}

}

