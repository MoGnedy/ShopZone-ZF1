<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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


}













