<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
 protected $_name  ='product';
    function addNewProduct($productData){

        $row = $this->createRow();
        $row->name = $productData['name'];
        $row->description = $productData['description'];
        $row->price = floatval($productData['price']);
        $row->picture = $productData['picture'];
        $row->quantity = intval($productData['quantity']);
        $row->category = $productData['category'];
        $row->save();
    }
    
    
    function listProducts(){
        return $this->fetchAll()->toArray();
    }
    
    
    function deleteProduct($id){
        $this->delete("id=$id");
    }
    
    
    function productDetails($id){
        return $this-> find($id)->toArray();
    }

    
    function listCusomerProducts($customer){
        $db=Zend_Db_Table::getDefaultAdapter();
        $select=new Zend_Db_Select($db);
        $select->from('product','*')
                ->where("customer_id=.$customer");
        return $db->fetchAll($select);
    }

    function updateProduct($id,$productData)
    {
      $productData['name']=$productData['name'];
      $productData['description']=$productData['description'];
      $productData['price']=$productData['price'];
      $productData['picture']=$$productData['picture'];
      $productData['quantity']=$productData['quantity'];
      $productData['category']=$productData['category'];
      $this->update($productData,"id=$id");

    }
    
    function listProductcomments($id){
        $db=Zend_Db_Table::getDefaultAdapter();
        $select=new Zend_Db_Select($db);
        $select->from('comment','*')
                ->where('product= ?',$id);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
    }
    
}

