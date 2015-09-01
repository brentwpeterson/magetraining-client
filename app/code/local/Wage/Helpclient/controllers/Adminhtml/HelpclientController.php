<?php

class Wage_Helpclient_Adminhtml_HelpclientController extends Mage_Adminhtml_Controller_action
{

	public function indexAction() 
	{
		if(!Mage::app()->getRequest()->getParam('action_name')) {
            $result['success'] = false;
	        $result['error_messages'] = $this->__('Help guides not found.');
	        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	        return;
        }else{

	        $locale_code = Mage::app()->getRequest()->getParam('locale_code');
	        $front_module = Mage::app()->getRequest()->getParam('front_module');
	        $controller_name = Mage::app()->getRequest()->getParam('controller_name');
	        $action_name = Mage::app()->getRequest()->getParam('action_name');
	        $suffix = Mage::app()->getRequest()->getParam('suffix');
	        $magento_help_url = Mage::app()->getRequest()->getParam('magento_help_url');


        	$apiuser = Mage::getStoreConfig('helpclient/api/apiuser');
        	$apipass = Mage::getStoreConfig('helpclient/api/apipass');
        	$url = Mage::getStoreConfig('helpclient/api/apiurl');
			$url .= '/api/soap/?wsdl';

			$result = array();

			$proxy = new SoapClient($url);
			$sessionId = $proxy->login($apiuser, $apipass);	
			if(!empty($sessionId )){
				$filters = array( array('type' => array('eq'=>'helpadmin'),'locale_code'=>array('eq'=>$locale_code),'front_module'=>array('eq'=>$front_module),'controller_name'=>array('eq'=>$controller_name),'action_name'=>array('eq'=>$action_name)) );
				$result = $proxy->call($sessionId, 'catalog_product.list', $filters);
			}
			

			$html = '<div class="block-content">
				        <p class="block-subtitle">MageTraining Help</p>
	            		<ol class="helpclient-products-list" id="helpclient-popup">';

	        foreach($result as $key => $value){
	        	$html .= '<li class="item">        
		                        <div class="product-details">
		                			<p class="product-name"><a href="'.$value['product_url'].'">'.$value['name'].'</a></p>
		                		</div>
							</li>';
	        }   

	        if(empty($result))
	        {
	        	$html .= '<li class="item">        
	                        <div class="product-details">
	                			<p class="product-name">No Help Guides Found..</p>
	                		</div>
							</li>';
	        }

	        $html .= 	'</ol>
	                    <div class="j-actions">
                			<a target="_blank" href="'.$magento_help_url.'" >Default Magento Help</a>
            			</div>
	                    <div class="help-search">
                			<input type="text" onkeypress="HelpAjaxObj.locate(event);" placeholder="Search MageTraining Help" class="input-text" name="helpquery" id="helpquery_search" autocomplete="off">
            			</div>
	                    <div class="j-actions">
                			<a href="javascript:void(0);" onclick="HelpAjaxObj.openMyPopup();" >How to use MageTraining help</a>
            			</div>
            		</div>';

			$result['html'] = $html;
        	$result['success'] = true;
	        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	        return;         	
        }
		
	}
}