<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

 protected function _initMyDb() {
    $dbAdapter = Zend_Db::factory('PDO_MYSQL', array(
         'host'     => '127.0.0.1',
         'username' => 'root',
         'password' => 'root',
         'dbname'   => 'ShopZoneDB'
    ));
    Zend_Db_Table::setDefaultAdapter($dbAdapter);
  }

}

