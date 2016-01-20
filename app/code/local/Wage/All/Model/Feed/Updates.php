<?php

class Wage_All_Model_Feed_Updates extends Wage_All_Model_Feed_Abstract
{

    /**
     * Retrieve feed url
     *
     * @return string
     */
    public function getFeedUrl()
    {
        return Wage_All_Helper_Config::UPDATES_FEED_URL;
    }

    /**
     * Checks feed
     * @return
     */
    public function check()
    {
        $session = Mage::getSingleton('admin/session');
        if ($session->isLoggedIn()) {
            if ((time() - Mage::app()->loadCache('wage_all_updates_feed_lastcheck')) > Mage::getStoreConfig('wageall/feed/check_frequency')) {
                $this->refresh();
            }
        }
    }

    public function refresh()
    {
        $feedData = array();

        try {

            $Node = $this->getFeedData();
            if (!$Node) return false;
            foreach ($Node->children() as $item) {
                if((int)$item->status){
                    $feedData[] = array(
                        'severity' => (int)$item->severity ? (int)$item->severity : 3,
                        'date_added' => $this->getDate((string)$item->date),
                        'title' => (string)$item->title,
                        'description' => (string)$item->content,
                        'url' => (string)$item->url,
                    );
                }
            }

            $adminnotificationModel = Mage::getModel('adminnotification/inbox');
            if ($feedData && is_object($adminnotificationModel)) {
                $adminnotificationModel->parse(($feedData));
            }

            Mage::app()->saveCache(time(), 'wage_all_updates_feed_lastcheck');
            return true;
        } catch (Exception $E) {
            return false;
        }
    }

}