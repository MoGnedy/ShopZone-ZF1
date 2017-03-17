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


}



