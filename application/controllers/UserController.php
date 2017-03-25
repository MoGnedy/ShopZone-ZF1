<?php

class UserController extends Zend_Controller_Action
{

    public $fpS = null;

    public function init()
    {
//         $this->fpS = new Zend_Session_Namespace('facebook');
//         $authorization = Zend_Auth::getInstance();
//        $fbsession = new Zend_Session_Namespace('facebook');
//
//        $request=$this->getRequest();
//        $actionName=$request->getActionName();
//
//          if ((!$authorization->hasIdentity() && !isset($fbsession->name)) && ($actionName != 'login' && $actionName != 'fblogin' && $actionName !='facebookcallback'))
//          {
//
//              $this->redirect('/user/login');
//          }
//
//
//          if (($authorization->hasIdentity() || isset($fbsession->fname)) && ($actionName == 'login' || $actionName == 'fblogin'))
//          {
//            $this->redirect('/index');
//
//        }
      //for arabic
       $request= $this->getRequest()->getParam('ln');
      //echo $request;      
       if(empty($request)){
         $this->language= new Zend_Session_Namespace('language');
          $this->language->type = isset($this->language->type)?$this->language->type:"En";
          // echo $this->language->type;
      }
      else{
          $this->language= new Zend_Session_Namespace('language');
          $this->language->type = $request ;
          // echo $this->language->type;

      }
            $this->view->language=$this->language;
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        // action body
          $form=new Application_Form_Signup();
        $this->view->user_form= $form;
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
                $user_model = new Application_Model_Customer();
                $user_model-> SignUp($request->getParams());
            }
        }
    }

    public function loginAction()
    {
        // action body

        $loginForm=new Application_Form_Login();
        $request=$this->getRequest();
        if($request->isPost()){
          if ($loginForm->isValid($request->getPost())) {
            //Array ( [name] => والتنم [pass] => كةىتﻻاىةزظ [Login] => Login )
            $name=$request->getParam('name');
            $pass=$request->getParam('pass');
            $dp=Zend_Db_Table::getDefaultAdapter();
            $adapter=new Zend_Auth_Adapter_DbTable($dp,'customer','name','password');
            $adapter->setIdentity($name);
            $adapter->setCredential($pass);
            $result=$adapter->authenticate();
            if ($result->isValid()) {
              $sessionDataObj=$adapter->getResultRowObject(['email','name','id','type']);
              $auth=Zend_Auth::getInstance();
              $storage=$auth->getStorage();
              $storage->write($sessionDataObj);

            }
          }
          else{
            $this->view->error_message="Invalid Email or password";

          }
        }
        $this->view->loginform_var=$loginForm;
    }

    public function fbloginAction()
    {
        // action body
         $fb = new Facebook\Facebook([
        'app_id' => '1767915360190950', // Replace {app-id} with your app id
        'app_secret' => '150fbee6425745ae2d8de9092073afef',
        'default_graph_version' => 'v2.2',
]);

        $helper = $fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($this->view->serverUrl() .'/user/facebookcallback');
        $this->view->facebookUrl =$loginUrl;
    }

    public function facebookcallbackAction()
    {
        // action body
        $fb = new Facebook\Facebook([
        'app_id' => '1767915360190950', // Replace {app-id} with your app id
        'app_secret' => '150fbee6425745ae2d8de9092073afef',
        'default_graph_version' => 'v2.2',
        ]);

$helper = $fb->getRedirectLoginHelper();

try {
$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
echo 'Graph returned an error: ' . $e->getMessage();
exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
echo 'Facebook SDK returned an error: ' . $e->getMessage();
exit;
}

if (! isset($accessToken)) {
if ($helper->getError()) {
header('HTTP/1.0 401 Unauthorized');
echo "Error: " . $helper->getError() . "\n";
echo "Error Code: " . $helper->getErrorCode() . "\n";
echo "Error Reason: " . $helper->getErrorReason() . "\n";
echo "Error Description: " . $helper->getErrorDescription() . "\n";
} else {
header('HTTP/1.0 400 Bad Request');
echo 'Bad request';
}
exit;
}
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

if (! $accessToken->isLongLived()) {
// Exchanges a short-lived access token for a long-lived one
try {
$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
} catch (Facebook\Exceptions\FacebookSDKException $e) {
echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
exit;
}

echo '<h3>Long-lived</h3>';

}
$fb->setDefaultAccessToken($accessToken);

try {
$response = $fb->get('/me');
$userNode = $response->getGraphUser();

}
catch (Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
echo 'Graph returned an error: ' . $e->getMessage();
Exit;
}
catch (Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
echo 'Facebook SDK returned an error: ' . $e->getMessage();
Exit;
}

$this->fpS->name = $userNode['name'];

    }

    public function delwishlistAction()
    {
        // action body
         //check to delete just product
        //check if it empty after u check function work
        $Wish_model = new Application_Model_Wishlist();
        $Wish_id = $this->_request->getParam("wid");
        $Wish_model->deleteWish($Wish_id);
        $this->redirect("/user/listwishlist");
    }

    public function inserwishlistAction()
    {

          // action body
         $Wish_model = new Application_Model_Wishlist();
            //check to send it
            $check = [];
            $p_id=$this->_request->getParam("uid");
            $check[] = $p_id;
            $check[]  = 1;
            // $check=$Wish_model->find($customer_id,$product_id)->toArray()[0];
            // $test=$Wish_model-> AddToWishList($request->getParams());
            $test=$Wish_model-> AddToWishList($check);

            $this->redirect('/index/index');

        $this->view->wish_data = $test;

    }

    public function listwishlistAction()
    {
 // action body
        $Wish_model = new Application_Model_Wishlist();
       // $uid=$this->fetchAll()->toArray();
        $Wish_id = $this->_request->getParam("wid");
         // var_dump($uid);
        // die();
        $this->view->model = $Wish_model->SelectionWishList($Wish_id);
    }


    public function sendemailAction()
    {
        // action body
        $code = $this->_request->getParam("code");
        $discount=$this->_request->getParam("discount");
        $customer_model = new Application_Model_Customer();
        $us_id = $this->_request->getParam("uid");
        $user = $customer_model->userDetails($us_id);
        $name=$user['name'];
            $body="Hello $name We have made a discount for you with amount of $discount %
                for the upcoming purchase Order.
    write this in discount field when purchasing next time :-
    $code";
        $mail = new Zend_Mail();
        $mail->addTo($user['email']);
        $mail->setSubject('Coupon');
        $mail->setBodyText($body);
        $mail->setFrom('bassant.ahly@gmail.com', 'Bassant');

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
                $this->redirect('/admin/listallusers');



            }

    public function facelogoutAction()
    {
        // action body
    $auth=Zend_Auth::getInstance();
    Zend_Session::namespaceUnset('facebook');

    $auth->clearIdentity();

    return $this->redirect('/user/login');

    }

    public function googleloginAction()
    {
        // action
        $this->view->googlelogin;
    }

   public function listcategoryAction()
    {
      $category_model= new Application_Model_Category();
      $this->view->category = $category_model->listAll();
    }

    public function listproductAction()
    {
      $product_model=new Application_Model_Product();
      $request = $this->getRequest();
        if($request->isPost()){
        $rate_model = new Application_Model_Rate();
        $rate_model->addNewRate($_POST);

        }
      $this->view->product =  $product_model->listProducts();
    }

    public function detailsproductAction()
    {
      $product_model = new Application_Model_Product();
      $comment_form = new Application_Form_Commentform();
      $request = $this->getRequest();
      $this->view->comment_form = $comment_form;
      $p_id = $this->_request->getParam('uid');
      $product = $product_model->productDetails($p_id);
      $this->view->comments = $product_model->listProductcomments($p_id);
      $this->view->product = $product;
      $this->view->allcoments = $product_model->SelectionComment($p_id);
      if($request->isPost()){
          if(!empty($request->getPost('comment'))){
             
      if($comment_form->isValid($request->getPost())){
      $comment_model = new Application_Model_Comment();
      $pid=$request->getParam('uid');
      $request->setParam('product', $pid);
      
      $request->setParam('customer_id', $_SESSION["Zend_Auth"]["storage"]->id);

      
      $comment_model->addComment ($request->getParams());
      $this->redirect("/user/detailsproduct/uid/$pid");
      
      
      }
      }
      elseif (!empty($request->getPost('star'))) {
            $rate_model = new Application_Model_Rate();
            $rate_model->addNewRate($_POST);
         }
      
      }
       
       
       
       
       
       
       
       
       
       
       
       
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

    public function addtocartAction()
    {
      $cart=new Application_Model_Cartitem();
      $cart->addProduct($_POST);
      $this->redirect("/user/detailsproduct/uid/".$_POST['product']);
    }

    public function displaycartAction()
    {
      $cartmodel=new Application_Model_Cartitem();
      $data = $cartmodel->selectoffer($_SESSION["Zend_Auth"]["storage"]->id);
      $this->view->cart =  $cartmodel->checkOffer($data);
      $this->view->userid=$_SESSION["Zend_Auth"]["storage"]->id;
      // var_dump($this->view->cart);
      // die();

      // //******** get price of each item and pushing it in array (product) *******
      // $cartarray= array();
      // foreach ($this->view->cart as $key => $value) {
      //   // print_r($value);
      //   // die();
      //   array_push($cartarray,$cartmodel->selectprice($value['product']));
      // }
      // $this->view->product= $cartarray;
      // // print_r($this->view->product);
      // // die();
      // //**********************************************
      // //*********select offer for each item if found and pushing it in
      // $offerarray= array();
      // foreach ($this->view->cart as $key => $value) {
      //
      //   array_push($cartarray,$cartmodel->selectoffer($value['product']));
      // }
      // $this->view->offers= $offerarray;
      // print_r($this->view->offers);
      // die();
      // //**************************
    }

    public function sendbillAction()
    {
      //this function make to functionalty 1-check for copun string is right for this user
      //2- send mail to user with ditails of the bill

      $uid=1;
      //check copun string
      $order=new Application_Model_Coupon();
      $cpn=$this->_request->getParam("cpn");
      $resultdis=$order->checkdis($cpn);
      if ($resultdis==0) {
        $resultdis="the copoun is wrong";
      }
      else{
        $resultdis="your copoun string \"".$cpn."\" have discount";
      }
      // echo $resultdis;
      // die();
      //****sending mail
      $sendingcart=new Application_Model_Cartitem();
      $this->view->cart =  $sendingcart->selectoffer($uid);
      //converting $this->view->cart array to readable string to be send to the user in well formed table

      $emailbody="";
      $total=0;
      foreach ($this->view->cart as $key => $value) {
      $afterdis=($value['quantity']*$value['price']*($value['offer_per']/100));
        $emailbody=$emailbody." ".$value['name']." ".$value['quantity']." ".$value['price']." ".$afterdis." <br>";
      $total+=$afterdis;
      }
      $emailbody=$emailbody."<br> your total net price after adding offers ".$total."<br>";

      $sendEmail=new Application_Model_Customer();
      $user = $sendEmail->userDetails($uid);
      $name=$user['name'];
      $email=$user['email'];
      $subject="bill";
      $body=$emailbody."<br>".$resultdis;

      $send_email=$sendEmail->sendEmail($email,$subject,$body);
      // print_r($sendemail);
      // die();
      $this->redirect('/user/displaycart');
    }

    public function deleteproductcartAction()
    {
      $user_model=new Application_Model_Cartitem();
      $usr_id=$this->_request->getParam("pid");
      $user_model->deleteItem($usr_id);
      $this->redirect("/user/displaycart");
    }


}





?>
