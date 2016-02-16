<?php

class Wage_Helpclient_Helper_Data extends Mage_Core_Helper_Abstract
{

    /** Products Updates feed path */
    const HELP_PRODUCTS_FEED_URL = 'http://www.magetraining.com/wagehelpproducts.xml';

    /** Videos Updates feed path */
    const VIDEOS_FEED_URL = 'http://www.magetraining.com/wagevideo.xml';

    /** store URL */
    const STORE_URL = 'http://www.magetraining.com';

  	public function jsParam($obj)
     {
     	$videoModel = Mage::getModel('helpclient/Video')->load(1);	

          if($videoModel->getUrl()){ $videoUrl = $videoModel->getUrl(); }else{ $videoUrl = ''; }
          if($videoModel->getWidth()){ $videoWidth = $videoModel->getWidth(); }else{ $videoWidth = ''; }
          if($videoModel->getHeight()){ $videoHeight = $videoModel->getHeight(); }else{ $videoHeight = ''; }

    		$param = array(
           'base_url' => 'http://www.magetraining.com',
           'video_url' => $videoUrl,
           'video_width' => $videoWidth,
           'video_height' => $videoHeight
    		);
        
        return Zend_Json::encode($param);
     }

      public function getHelpProduct()
      {
          $request = Mage::app()->getRequest();
          $frontModule = $request->getControllerModule();
          if (!$frontModule) {
              $frontName = $request->getModuleName();
              $router = Mage::app()->getFrontController()->getRouterByFrontName($frontName);

              $frontModule = $router->getModuleByFrontName($frontName);
              if (is_array($frontModule)) {
                  $frontModule = $frontModule[0];
              }
          }
          $locale_code = Mage::app()->getLocale()->getLocaleCode();
          $front_module = $frontModule;
          $controller_name = $request->getControllerName();
          $action_name = $request->getActionName();
          $suffix =  Mage::app()->getRequest()->getParam('section');

           $html = '';

           $collection = Mage::getModel('helpclient/helpclient')->getCollection();
           //$collection->addFieldToFilter('locale_code', $locale_code);
           $collection->addFieldToFilter('front_module', $front_module);
           $collection->addFieldToFilter('controller_name', $controller_name);
           $collection->addFieldToFilter('action_name', $action_name);
           $collection->addFieldToFilter('suffix', $suffix);

           if(!count($collection)) {
              $html .= '<li class="item">        
                          <div class="product-details">
                             <p class="product-name">No Help Guides Found..</p>
                          </div>
                       </li>';  
           }

           foreach($collection as $value)
           {  
              if($value->getShortDescription()){ $getShortDescription = substr($value->getShortDescription(),0,100).'...'; }else{ $getShortDescription = ''; }
              $html .= '<li class="item">        
                          <div class="product-details">
                             <p class="product-name">
                                <a target="_blank" href="'.$value->getProductUrl().'">'.$value->getName().'</a>
                                <p>'.$this->stripTags($getShortDescription).'</p>
                             </p>
                          </div>
                       </li>'; 
           }

           return $html;
      }    

     	public function objectToArray($obj)
     	{
     		if (is_object($d)) {
          	$d = get_object_vars($d);
      	}
   
       	if (is_array($d)) {
  	        return array_map(__FUNCTION__, $d);
       	} else {
          	return $d;
       	}
     	}

}