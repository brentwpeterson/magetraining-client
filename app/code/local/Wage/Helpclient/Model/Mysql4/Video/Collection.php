<?php
class Wage_Helpclient_Model_Mysql4_Video_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('helpclient/video');
    }
}
