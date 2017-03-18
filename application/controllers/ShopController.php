<?php

class ShopController extends Zend_Controller_Action
{

    private $product_model = null;

    public function init()
    {
     $product_model = new Application_Model_Product();
    }

    public function indexAction()
    {
        // action body
    }

    public function addproductAction()
    {
        $form = new Application_Form_Productform();
        $form->setAttrib('enctype', 'multipart/form-data');
        $this->view->productForm = $form;
        $request = $this->getRequest();
        if($request->isPost()){
        if($form->isValid($request->getPost())){
        $product_model = new Application_Model_Product();
        
        $location = $form->picture->getFileName();
        //print_r($location);
        $request->setParam('picture', $location);
        
        $values = $form->getValues();
 

        if (!$form->picture->receive()) {
            print "Upload error";
        }
        $product_model->addNewProduct($request->getParams());
        $this->redirect('/shop/listproducts');
                                                }
                              }
        
        
        
        
    }

    public function listproductsAction()
    {
        $product_model = new Application_Model_Product();
        
        $this->view->products = $product_model->listProducts();
        
    }


  


    public function productdetailsAction()
    {
      $product_model = new Application_Model_Product();
      $p_id = $this->_request->getParam('pid');
      
      $product = $product_model->productDetails($p_id);
      $this->view->product = $product[0];
    }



    public function deleteproductAction()
    {
      $product_model = new Application_Model_Product();
      $p_id = $this->_request->getParam('pid');
      $user = $product_model->deleteProduct($p_id);
      $this->redirect("/shop/listproducts");
    }

    public function editproductAction()
    {
        $form = new Application_Form_Productform ();
        $product_model = new Application_Model_Product ();
        $id = $this->_request->getParam('pid');
        $product_data = $product_model->productDetails($id)[0];
        $form->populate($product_data);
        $this->view->product_form = $form;
        $request = $this->getRequest();
        if($request->isPost()){
        if($form->isValid($request->getPost())){
        $product_model->updateProduct($id, $_POST);
        $this->redirect('/shop/listproducts');
        }
        }

    }

        public function editofferAction()
    {
        $form = new Application_Form_Offer ();
        $offer_model = new Application_Model_Offer ();
        $id = $this->_request->getParam('oid');
        $offer_data = $offer_model->offerDetails($id)[0];
        $form->populate($offer_data);
        $this->view->offer_form = $form;
        $request = $this->getRequest();
        if($request->isPost()){
        if($form->isValid($request->getPost())){
        $product_model->updateOfferData($id, $_POST);
        $this->redirect('/shop/listOffers');
        }
        }

    }


    public function addOfferAction()
    {

    
        $form = new Application_Form_Offer();

        $this->view->offer_form = $form; 

        $request = $this->getRequest();
        if($request->isPost())
        {
            if($form->isValid($request->getPost()))
            {
                $offer_model = new Application_Model_Offer();
                $offer_model-> addNewOffer($request->getParams());
                $this->redirect('/shop/listOffers');
            }
        }
    
        // action body
    }

   public function listOffersAction()
    {
        $offer_model = new Application_Model_Offer();
        
        $this->view->offers = $offer_model->getAllOffers();
        
    }


   public function offerdetailsAction()
    {
      $offer_model = new Application_Form_Offer();
      $id = $this->_request->getParam('oid');
      
      $offer = $offer_model->offerDetails($id);
      $this->view->offer = $offer[0];
    }    

    public function deleteofferAction()
    {
      $offer_model = new Application_Form_Offer();
      $id = $this->_request->getParam('oid');
      $user = $offer_model->deleteOffer($id);
      $this->redirect("/shop/listOffers");
    }

}






