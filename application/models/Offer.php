<?php

class Application_Model_Offer extends Zend_Db_Table_Abstract
{

	protected $_name='offer';


	function getAllOffers()
		{
		return $this->fetchAll()->toArray();
		}


	function addNewOffer($newOffer)
	{
	$row = $this->createRow();
	$row->offer_per = $newOffer['offer_per'];
	$row->offer_start = $newOffer['offer_start'];
	$row->offer_end = $newOffer['offer_end'];

	
	$row->save();
	}


	public function deleteOffer($id)
		{
		$this->delete("id=$id");
		}

	function offerDetails($id)
		{
		return $this->find($id)->toArray();
		}

	function updateOfferData($id,$formData)
	{


	  $offerData1['offer_per']=$formData['offer_per'];
	  $offerData1['offer_start']=$formData['offer_start'];
	  $offerData1['offer_end']=$formData['offer_end'];
	  $this->update($offerData1,"id=$id");
	}	

}

