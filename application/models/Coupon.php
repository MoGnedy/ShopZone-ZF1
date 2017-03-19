<?php

class Application_Model_Coupon extends Zend_Db_Table_Abstract
{
    protected $_name  ='coupon';
        public function addCoupon($data){
    	
  		$coupon['order']=$data['order'];
  		$coupon['code']=$data['code'];
  		$coupon['discount']=$data['discount'];
                $coupon['customer']=$data['customer'];
  		$row=$this->createRow($coupon);
  		$row->save();
}


}

