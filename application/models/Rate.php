<?php

class Application_Model_Rate extends Zend_Db_Table_Abstract
{
    protected $_name  ='rate';
    
    function addNewRate($newrate)
	{
	
        
        $select=$this->select()
                ->from('rate','*')
                //->where('product= ?',$newrate['product'] and 'customer= ?',$newrate['customer']);
                ->where('product= ?',$newrate['product'])
                ->where('customer= ?',$newrate['customer']);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
        if (empty($result)){
        $row = $this->createRow();
        $row->customer = $newrate['customer'];
	$row->product = $newrate['product'];
	$row->rate = $newrate['star'];
        $row->save();
        
        $product_model = new Application_Model_Product();
        //$product_model->update(['total_users_rate'=>'total_users_rate+1','total_rates'=>'total_rates+$newrate['star']'],'id='.$newrate['customer']);
        $data=array('total_users_rate'=>new Zend_Db_Expr('total_users_rate + 1'),'total_rates'=>new Zend_Db_Expr('total_rates +'.$newrate['star']));
        $where='id='.$newrate['product'];
        $product_model->update($data, $where);
        
         }
         
         else {
        $old = $this->select()
                ->from('rate','rate')
                ->where('customer=?',$newrate['customer'])
                ->where('product=?',$newrate['product']);
        $old = $old->query();
        $old = $old->fetchAll();
        $old = $old[0]['rate'];
        $new =  $newrate['star'] - $old ; 
        $data=array('rate'=>new Zend_Db_Expr($newrate['star']));
        $where='customer='.$newrate['customer'];
        $this->update($data, $where);
        $product_model = new Application_Model_Product();
        //$product_model->update(['total_users_rate'=>'total_users_rate+1','total_rates'=>'total_rates+$newrate['star']'],'id='.$newrate['customer']);
        $data=array('total_rates'=>new Zend_Db_Expr('total_rates +'.$new));
        $where='id='.$newrate['product'];
        $product_model->update($data, $where);
             
             
         }
      
	}
}

