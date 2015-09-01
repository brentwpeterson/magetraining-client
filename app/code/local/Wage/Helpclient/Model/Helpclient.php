<?php

class Wage_Helpclient_Model_Helpclient extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('helpclient/helpclient');
    }

    public function fetchHelpGuideProducts() {

    	$apiuser = Mage::getStoreConfig('helpclient/api/apiuser');
    	$apipass = Mage::getStoreConfig('helpclient/api/apipass');
    	$url = Mage::getStoreConfig('helpclient/api/apiurl');
		$url .= '/api/soap/?wsdl';

		$result = array();

		$proxy = new SoapClient($url);
		$sessionId = $proxy->login($apiuser, $apipass);	
		if(!empty($sessionId )){
			$filters = array( array('type' => array('eq'=>'helpadmin')) );
			$result = $proxy->call($sessionId, 'catalog_product.list', $filters);
		}

		foreach($result as $value)
		{
			$loadedProduct = $this->loadHelpProduct(trim($value['product_id']));
            if($loadedProduct->getId()) {
                $helpclientModel = Mage::getModel('helpclient/helpclient')->load($loadedProduct->getId());
            } else {
                $helpclientModel = Mage::getModel('helpclient/helpclient');
            }
	
			$helpclientModel->setProductId(trim($value['product_id']));
			$helpclientModel->setName(trim($value['name']));
			$helpclientModel->setType(trim($value['type']));
			$helpclientModel->setProductUrl(trim($value['product_url']));
			$helpclientModel->setLocaleCode(trim($value['locale_code']));
			$helpclientModel->setFrontModule(trim($value['front_module']));
			$helpclientModel->setControllerName(trim($value['controller_name']));
			$helpclientModel->setActionName(trim($value['action_name']));
			$helpclientModel->setSuffix(trim($value['suffix']));

			$helpclientModel->save();
		}

		if(!empty($sessionId )){
          $videoresult = $proxy->call($sessionId,  'helpapi.helpvideo', array());
        }

        if($videoresult['video_url']){ $videoUrl = $videoresult['video_url']; }else{ $videoUrl = ''; }
        if($videoresult['video_width']){ $videoWidth = $videoresult['video_width']; }else{ $videoUrl = ''; }
        if($videoresult['video_height']){ $videoHeight = $videoresult['video_height']; }else{ $videoUrl = ''; }


        $helpclientVideo = Mage::getModel('helpclient/video')->load(1);		
		$helpclientVideo->setUrl(trim($videoUrl));
		$helpclientVideo->setWidth(trim($videoWidth));
		$helpclientVideo->setHeight(trim($videoHeight));

		$helpclientVideo->save();

    }

	public function loadHelpProduct($productId)
    {

        $obj = Mage::getModel('helpclient/helpclient')->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->getFirstItem();
        return $obj;
    }
}