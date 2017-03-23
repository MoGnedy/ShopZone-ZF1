<?php

class Application_Model_Customer extends Zend_Db_Table_Abstract
{
    protected $_name  ='customer';

        public function SignUp($formData){
    	 $userData['name']=$formData['name'];

  		$userData['email']=$formData['email'];
  		$userData['type']=$formData['type'];
  		$userData['password']=md5($formData['password']);
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
        $select->from('customer','*')
                ->where('type= ?',$type);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        }
    }
    function userDetails($id)
  {
    return $this->find($id)->toArray()[0];
  }
  function updateUser($id,$formData){

      $userData['name']=$formData['name'];
      $userData['email']=$formData['email'];
      $userData['address']=$formData['address'];
      $userData['type']=$formData['type'];
      $this->update($userData,"id=$id");
}

function deleteUser($id)
  {
    $this->delete("id=$id");
  }
  function blockUser($id){
    $userData['is_active']="false";
    $this->update($userData,"id=$id");
  }
  function activeUser($id){
    $userData['is_active']="true";
    $this->update($userData,"id=$id");
  }
  public function sendEmail($email,$subject,$body){
        $mail = new Zend_Mail();
        $mail->addTo($email);
        $mail->setSubject($subject);
        $mail->setBodyText($body);
        $mail->setFrom('Admin@ShopeZone.com', 'Admin');

//Send it!
        $sent = true;
        try {
            $mail->send();
        } catch (Exception $e){
            $sent = false;
        }

        //Do stuff (display error message, log it, redirect user, etc)
        if($sent){
            echo 'Mail was sent successfully.';
        } else {
            echo 'Mail failed to send.';
        }
  }

   function getEmail($email){
      $user_model = new Application_Model_Customer();
     $select = $user_model->select()
              ->from('customer','email')
                ->where('email= ?',$email);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
  
  
}


function randomCode(){
    $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $code =''; 
     
     
        for($i=0;$i<30; $i++)
        {
            $code .= $chars[rand(0,strlen($chars)-1)];
        }

        return $code;
        }
        
        function checkCode($code){
        
            $user_model = new Application_Model_Customer();
     $select = $user_model->select()
              ->from('customer','reset_password')
                ->where('reset_password= ?',$code);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        }
       
         function getCodeEmail($code){
        
            $user_model = new Application_Model_Customer();
     $select = $user_model->select()
              ->from('customer','email')
                ->where('reset_password= ?',$code);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        }
        
        function deleteCode($email){
        
            $data = array(
                       'reset_password' => "",
                       
                    );
                    $where = $this->getAdapter()->quoteInto('email = ?', $email);
                    
                    
                    $this->update($data,$where);
        }
  }
 