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

        //3amal mshkla m3 cody
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

    public function addtocartAction()
    {
      $cart=new Application_Model_Cartitem();




      $cart->addProduct($_POST);
      $uid=$_POST[product];
      $this->redirect("/index/details-product/uid/".$uid);

    }

   


}


