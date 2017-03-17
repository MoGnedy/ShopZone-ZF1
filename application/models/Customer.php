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
    
    function listusers($type=null){
        //var_dump(empty($type));
        
        if (empty($type)){
          
           return $this->fetchAll()->toArray();
        }
        else{
        $db=Zend_Db_Table::getDefaultAdapter();
        $select=new Zend_Db_Select($db);
        $select->from('customer')
                ->where('type='.$type);
        return $db->fetchAll($select)->toArray();
        }
    }
}

