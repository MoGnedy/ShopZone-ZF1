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

    }

     function facelogoutAction()
    {
        // action body
    $auth=Zend_Auth::getInstance();
    Zend_Session::namespaceUnset('facebook');

    $auth->clearIdentity();

    return $this->redirect('user/login');

    }
     function googleloginAction()
    {
        // action
        $this->view->googlelogin;
    }



?>
