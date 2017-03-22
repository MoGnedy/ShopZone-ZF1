<?php

class IndexController extends Zend_Controller_Action
{

    public $fpS = null;

    public function init()
    {
         $this->fpS = new Zend_Session_Namespace('facebook');
         $authorization = Zend_Auth::getInstance();
         $fbsession = new Zend_Session_Namespace('facebook');
         $request=$this->getRequest();
         $actionName=$request->getActionName();

//          if ((!$authorization->hasIdentity() && !isset($fbsession->name)) && ($actionName != 'login' && $actionName !='facebookcallback'))
//          {

//              $this->redirect('/index/login');
//          }
// //
// //
//          if (($authorization->hasIdentity() || isset($fbsession->name)) && ($actionName ='login'))
//          {
//              // $this->redirect('/index');

//        }
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
         $category_model= new Application_Model_Category();
        $this->view->category = $category_model->listAll();
         $select_model=new Application_Model_Product();
        $this->view->rate_product =$select_model->selectproductrate();
                $Slider_model=new Application_Model_Slider();
        
        $this->view->select_image =$Slider_model->slider();
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
        $Slider_model=new Application_Model_Slider();
        
        $this->view->select_image =$Slider_model->slider();
    }

    public function registerAction()
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

        $loginForm=new Application_Form_Login();
        $request=$this->getRequest();
        if($request->isPost()){
          if ($loginForm->isValid($request->getPost())) {
            $email=$request->getParam('email');
            $pass=$request->getParam('pass');


            $dp=Zend_Db_Table::getDefaultAdapter();
            $adapter=new Zend_Auth_Adapter_DbTable($dp,'customer','email','password');
            $adapter->setIdentity($email);
            $adapter->setCredential($pass);
            $result=$adapter->authenticate();
            if ($result->isValid()) {
              $sessionDataObj=$adapter->getResultRowObject(['id','email','password','name','adress','type','is_active']);
              
            if($sessionDataObj->is_active == 'true'){
                $auth=Zend_Auth::getInstance();
                $storage=$auth->getStorage();
                $storage->write($sessionDataObj);
                $usersNs = new Zend_Session_NameSpace("members");
                $usersNs->userType = $sessionDataObj->type;
//                print_r($_SESSION);
//                die();
                if($sessionDataObj->type == 'admin')
                        {
                           
                            $this->redirect('/admin');
                        }elseif($sessionDataObj->type == 'shop user'){
                            $this->redirect('/shop');


                        }elseif($sessionDataObj->type == 'user'){
                               $this->redirect('/user');

                        }


            }else{
                 echo "You are blocked";


            }
          }
          else{
            $this->view->error_message="Invalid Email or password";

          }
        }
    }
              $this->view->loginform_var=$loginForm;
               $fb = new Facebook\Facebook([
        'app_id' => '1767915360190950', // Replace {app-id} with your app id
        'app_secret' => '150fbee6425745ae2d8de9092073afef',
        'default_graph_version' => 'v2.2',
]);

        $helper = $fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($this->view->serverUrl() .'/index/facebookcallback',array('scope' => 'email'));
        $this->view->facebookUrl =$loginUrl;
       
    }

    public function logoutAction()
    {
        // action body
        $auth=Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::namespaceUnset('facebook');
        Zend_Session::namespaceUnset('members');
        return $this->redirect('index/login');
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
$response = $fb->get('/me?fields=id,name,email');
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
$type='user';
$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password =''; 
     
     
        for($i=0;$i<10; $i++)
        {
            $password .= $chars[rand(0,strlen($chars)-1)];
        }
$user=array("name"=>$userNode['name'],"email"=>$userNode['email'],"type"=>$type,"password"=>$password,"address"=>"");
 $dp=Zend_Db_Table::getDefaultAdapter();
            $adapter=new Zend_Auth_Adapter_DbTable($dp,'customer','email','password');
            $adapter->setIdentity($userNode['email']);
            $adapter->setCredential($password);
             $result=$adapter->authenticate();
             if(!$result){
            $user_model = new Application_Model_Customer();
                $user_model-> SignUp($user);
            }

    }

    public function searchAction()
    {
        // action body
    }


}



    













