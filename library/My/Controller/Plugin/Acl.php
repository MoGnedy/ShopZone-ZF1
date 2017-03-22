<?php
class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = Zend_Registry::get('acl');
        
        /**
        
        When user login, simply write this code where you have placed code for the login purpose.
        $usersNs = new Zend_Session_NameSpace("members");
        $usersNs->userType = 'admin';
        OR
        $usersNs->userType = 'editor';
        OR
        $usersNs->userType = 'publisher';
        Like that...
        
        */
       //session_destroy();
        $usersNs = new Zend_Session_NameSpace("members");
         //$usersNs = new Zend_Session_NameSpace("members");
        //$usersNs->userType = $_SESSION['type'];
        //print_r($usersNs->userType);
        //print_r($_SESSION['members'][userType]);
        //die();
        
        if($usersNs->userType=='')
        {
            $roleName='guest';
        } 
        else 
        {
            $roleName=$usersNs->userType;
        }
        
        $privilageName=$request->getActionName();
        $controllerName=$request->getControllerName();
        
        if(!$acl->isAllowed($roleName,$controllerName,$privilageName))
        {
//            $request->setControllerName('Error');
//            $request->setActionName('index');
            
            
            $request->setControllerName('index');
            $request->setActionName('index');
            
            // this will echo the output from file - /application/views/scripts/error/index.phtml
            // make sure, you have the controller - ErrorController with action indexAction
            // and also make sure you have phtml file for it 
            // i.e. /application/views/scripts/error/index.phtml
        }
    }
}