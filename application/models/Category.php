<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
 protected $_name  ='category';

  function listAll(){
    return $this->fetchAll()->toArray();
  }

  function addCat($catData)
  {
  $row = $this->createRow();
  $row->name = $catData['name'];
  $row->save();
  }
  function getCat($cat_id)
  {
  return $this->find($cat_id)->toArray();
  }

}

