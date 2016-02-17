<?php

class Wage_Helpclient_Model_Feed extends Mage_Core_Model_Abstract
{
    /**
     * Checks feed
     * @return
     */
    public function fetchProducts()
    {
        $feedData = array();

        $session = Mage::getSingleton('admin/session');
        //if ($session->isLoggedIn()) {
            
            $Node = $this->getFeedData(Wage_Helpclient_Helper_Data::HELP_PRODUCTS_FEED_URL);
            if (!$Node) return false;
            foreach ($Node->children() as $item) {
                $feedData[] = array(
                    'product_id' => (int)$item->product_id,
                    'name' => (string)$item->name,
                    'type' => (string)$item->type,
                    'product_url' => (string)$item->product_url,
                    'locale_code' => (string)$item->locale_code,
                    'front_module' => (string)$item->front_module,
                    'controller_name' => (string)$item->controller_name,
                    'action_name' => (string)$item->action_name,
                    'suffix' => (string)$item->suffix,
                    'help_module_description' => (string)$item->help_module_description
                );
            }

        //}
        return $feedData;
    }

    public function fetchVideos()
    {
        $feedData = array();
        $session = Mage::getSingleton('admin/session');
        //if ($session->isLoggedIn()) {            
            $Node = $this->getFeedData(Wage_Helpclient_Helper_Data::VIDEOS_FEED_URL);
            if (!$Node) return false;

            $feedData['video'] = array(
                'url' => (string)$Node->url,
                'width' => (int)$Node->width,
                'height' => (int)$Node->height
            );
        //}
        return $feedData;
    }

    public function getFeedData($feedUrl)
    {
        $curl = new Varien_Http_Adapter_Curl();
        $curl->write(Zend_Http_Client::GET, $feedUrl, '1.0');
        $data = $curl->read();
        if ($data === false) {
            return false;
        }
        $data = preg_split('/^\r?$/m', $data, 2);
        $data = trim($data[1]);
        $curl->close();

        try {
            $xml = new SimpleXMLElement($data);
        }
        catch (Exception $e) {
            return false;
        }

        return $xml;
    }

}