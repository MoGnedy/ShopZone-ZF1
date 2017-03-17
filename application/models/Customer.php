<?php

class Application_Model_Customer extends Zend_Db_Table_Abstract
{
    protected $_name  ='customer';
        public function SignUp($formData){
    	 $userData['name']=$formData['name'];

  		$userData['email']=$formData['email'];
  		$userData['type']=$formData['type'];
  		$userData['password']=$formData['password'];
  		$userData['address']=$formData['address'];
  		$row=$this->createRow($userData);
  		$row->save();

    }

}

