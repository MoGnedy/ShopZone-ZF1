<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
         $category_model= new Application_Model_Category();
        $this->view->category = $category_model->listAll();
         $select_model=new Application_Model_Product();
        $this->view->rate_product =$select_model->selectproductrate();
                $slider_model=new Application_Model_Product();

         $this->view->select_image =$slider_model->slider();
    }

    public function listCategoryAction()
    {
        // action body
        $category_model= new Application_Model_Category();
        $this->view->category = $category_model->listAll();
    }

    public function detailsProductAction()
    {

        $product_model=new Application_Model_Product();
        $product_id = $this->_request->getParam("uid");
        $product_data = $product_model->ProductDetails($product_id);
        $this->view->product_data=$product_data[0];
        $addcart=new Application_Form_Addtocart();
        $this->view->form=$addcart;

        // $request = $this->getRequest();
        // if ($request->isPost()) {
        //     // $user_model=new Application_Model_User();
        //     // $user_model->($usr_id);
        //     // $this->redirect("/user/list");
        // }

    }

    public function listProductAction()
    {
        // action body
         $product_model=new Application_Model_Product();
        $id = $this->_request->getParam('uid');
        $this->view->product =$product_model->listProdCat($id);

    }

    public function selectrateprodAction()
    {
        // action body
         $select_model=new Application_Model_Product();
        
        $this->view->rate_product =$select_model->selectproductrate();

    }

    public function sliderAction()
    {
        // action body
        $product_model=new Application_Model_Product();
        
        $this->view->select_image =$product_model->slider();
    }


}




