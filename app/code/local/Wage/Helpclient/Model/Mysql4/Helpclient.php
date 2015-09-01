<?php

class Wage_Helpclient_Model_Mysql4_Helpclient extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the helpclient_id refers to the key field in your database table.
        $this->_init('helpclient/helpclient', 'id');
    }
}