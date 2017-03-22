<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('adminlayout');

    }

    public function indexAction()
    {
        // action body
    }

    public function listallusersAction()
    {
        $user_model = new Application_Model_Customer();
        $user_type = $this->_request->getParam('type');
//        print_r($user_type);
//        die();
        
        $this->view->users = $user_model->listusers($user_type);
       
       
    }

    public function userdetailsAction()
    {
        // action body
         $customer_model = new Application_Model_Customer();
        $us_id = $this->_request->getParam("uid");
        $user = $customer_model->userDetails($us_id);
        $this->view->user_data = $user;
    }

    public function edituserAction()
    {
        // action body
        $form = new Application_Form_Signup();
        $id=$this->_request->getParam('uid');
        $userModel= new Application_Model_Customer();
        $userData=$userModel->userDetails($id);
        $form->populate($userData);   
        $this->view->user_form=$form;
        $request = $this->getRequest();
        if($request-> isPost()){
        if($form-> isValid($request-> getPost())){
        $userModel-> updateUser ($id,$request->getPost());
        $this->redirect('/admin/listallusers ');

    }


}
    }

    public function deleteuserAction()
    {
        // action body
        $user_model = new Application_Model_Customer();
        $us_id = $this->_request->getParam("uid");
        $user_model->deleteUser($us_id);
        $this->redirect("/admin/listallusers");
    }

    public function blockuserAction()
    {
        // action body
          $user_model = new Application_Model_Customer();
        $us_id = $this->_request->getParam("uid");
        $user_model->blockUser($us_id);
        $this->redirect("/admin/listallusers");
    }

    public function activeuserAction()
    {
        // action body
        $user_model = new Application_Model_Customer();
        $us_id = $this->_request->getParam("uid");
        $user_model->activeUser($us_id);
        $this->redirect("/admin/listallusers");
    }

    public function sendcouponAction()
    {
        // action body
          $coupon=new Application_Model_Coupon();
      // echo $us_id = $this->_request->getParam("uid");
      // die();
           $request=$this->getRequest();
        if($request->isPost()){
            
        $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $code =''; 
     
     
        for($i=0;$i<30; $i++)
        {
            $code .= $chars[rand(0,strlen($chars)-1)];
        }
        $request->setParam('code', $code);
        $request->setParam('order', 1);
               // $request->setParam('order', 1);


       $coupon-> addCoupon($request->getParams());

        }
       // var_dump($request->getParams());
       $uid= $request->getParam('customer');
       $discount=$request->getParam('discount');
       $customer_model = new Application_Model_Customer();
        $user = $customer_model->userDetails($uid);
        $name=$user['name'];
       
       $email=$user['email'];

        $body="Hello $name We have made a discount for you with amount of $discount %
                for the upcoming purchase Order.
    write this in discount field when purchasing next time :-
    $code";
    $subject='Coupon';
   $customer_model=new Application_Model_Customer();
    $send_email=$customer_model->sendEmail($email,$subject,$body);
     $this->redirect('/admin/listallusers');

     // $this->redirect("/user/sendemail/uid/$uid/code/$code/discount/$discount");

    }

    public function addsliderAction()
    {
        // action body
        $form=new Application_Form_Sliderform();
        $form->setAttrib('enctype', 'multipart/form-data');
                $this->view->form = $form;

        $request = $this->getRequest();
         if($request->isPost()){
            if($form->isValid($request->getPost())){
                        $location = $form->picture->getFileName();
                                $request->setParam('picture', $location);

        $values = $form->getValues();
  if (!$form->picture->receive()) {
            print "Upload error";
        }
            $slider_model=new Application_Model_Slider();
            $slider_model-> addNewSlider($request->getParams());
            $this->redirect('/admin/addslider');
  }
}
}

    public function addcatAction()
    {
        $category_form = new Application_Form_Categoryform();
        $this->view->cat_form = $category_form;
           $request = $this->getRequest();
        if($request->isPost()){
        if($category_form->isValid($request->getPost())){
        $cat_model = new Application_Model_Category();
        $cat_model->addCat($request->getParams());
        $this->redirect('/admin/listcats');
        }
    }
    }

    public function listallcatsAction()
    {
       $category_model= new Application_Model_Category();
       $this->view->categories = $category_model->listAll();
    }

    public function editcatAction()
    {
        $cat_form = new Application_Form_Categoryform();
        $cat_id = $this->_request->getParam('cid');
        $cat_model = new Application_Model_Category();
        $cat_data = $cat_model->getCat($cat_id);
        $cat_form->populate($cat_data);
        $this->view->cat_form = $cat_form;
        $request = $this->getRequest();
        if($request-> isPost()){
        if($cat_form-> isValid($request-> getPost())){
        $cat_model-> updateUser ($cat_id,$request->getPost());
        $this->redirect('/admin/listallcats ');

        }
        }
    }

    public function deletecatAction()
    {
        $cat_model = new Application_Model_Category();
        $cat_id = $this->_request->getParam('cid');
        $cat_model->delete("id=$cat_id");
        $this->redirect("/admin/listallcats");
    }


}