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
      ->where("w.customer_id=$Wish_id")
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


public function AddToWishList($p_id)
{
  $uid=intval($_SESSION["Zend_Auth"]["storage"]->id);
    $pid=intval($p_id);
    $sql=$this->select()
    ->from(array('w'=>"wishlist"))
    ->where("w.product_id=$pid")
    ->where("w.customer_id=$uid")
    ->setIntegrityCheck(false);
      $query=$sql->query();
      // echo $sql->__toString();
      // die();
      $result=$query->fetchAll();
      // print_r($result);
      // die();
      // return $result;

     // var_dump($result[0]);
     //      die();
              if($result[0]==$pid && $result[1]>0){
                echo "is exist";
                return $result;
              }
        
                $row=$this->createRow();         
                $row->customer_id= $uid ;
                $row->product_id= $pid;
               $row->save();
            
        
      }

}


