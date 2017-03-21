<?php

class Application_Model_Slider extends Zend_Db_Table_Abstract
{
    protected $_name  ='slider';

     public function addNewSlider($sliderData){

        $row = $this->createRow();
        // $row->description = $productData['description'];
       // var_dump($sliderData);
       // die();
        $row->image =$sliderData['picture'];
    
        $row->url = $sliderData['description'];
        $row->save();
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

