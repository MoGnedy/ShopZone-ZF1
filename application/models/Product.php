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

        public function listProdCat($id)
    {

        $test=new Application_Model_Category();
        $sql=$test->ListCategory($id);
        return $sql;
      //   $sql=$this->select()
      // ->from(array('p'=>"product"))
      // ->joinInner(array("C"=>"category"), "p.category=C.id",array("name"))
      // // ->joinInner(array("p"=>"product"), "p.product_id=WL.product_id",array("name"))
      // // ->where("WL.id=$userId")
      // ->setIntegrityCheck(false);
      // $query=$sql->query();
      // $result=$query->fetchAll();
      // return $result;
    }
    public function SelectionComment($id)
    {
        $sql=$this->select()
        // ->from(array('c'=>"comment"))
        ->from(array('c'=>"comment",'p'=>"product"))
        ->joinInner(array("cu"=>"customer"), "c.customer_id=cu.id",array("name as customer_name"))
        ->joinInner(array("p"=>"product"), "p.id=c.product",array("name as product_name"))
        // ->joinInner(array())
        ->where("c.product=$id")
        ->order('date DESC')
        ->setIntegrityCheck(false);
        $query=$sql->query();
        // echo $sql->__toString();
        // die();
        $result=$query->fetchAll();
  
        return $result;

        

    }
    public function selectproductrate()
    {
        $sql=$this->select()
        ->from(array('p'=>"product"))
        // ->where("p.id=$id")
        ->order('rates_avg DESC')
        ->limit(10, 0)
        ->setIntegrityCheck(false);

        $query=$sql->query();
        // echo $sql->__toString();
        // die();
        $result=$query->fetchAll();
        return $result;
    }

     public function slider()
    {
        $sql=$this->select()
        ->from("slider",array('image','url'))
        // ->where("p.id=$id")
        ->limit(10, 0)
        ->setIntegrityCheck(false);

        $query=$sql->query();
        // echo $sql->__toString();
        // die();
        $result=$query->fetchAll();
        return $result;
    }


    
}

