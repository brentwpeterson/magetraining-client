<?php

class Wage_Helpclient_Model_Helpclient extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('helpclient/helpclient');
    }

    public function fetchHelpGuideProducts() 
    {

		$result = array();
		$result = Mage::getModel('helpclient/feed')->fetchProducts();

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
			$helpclientModel->setHelpModuleDescription(trim($value['help_module_description']));

			$helpclientModel->save();
		}

		$videoresult = Mage::getModel('helpclient/feed')->fetchVideos();
          
        if($videoresult['video']['url']){ $videoUrl = $videoresult['video']['url']; }else{ $videoUrl = ''; }
        if($videoresult['video']['width']){ $videoWidth = $videoresult['video']['width']; }else{ $videoUrl = ''; }
        if($videoresult['video']['height']){ $videoHeight = $videoresult['video']['height']; }else{ $videoUrl = ''; }


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