<?php

class Wage_Helpclient_Model_Observer
{    
    public function coreBlockAbstractToHtmlAfter($event)
    {
        /* @var $block Mage_Core_Block_Abstract */
        $block = $event->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Template && 'page/menu.phtml' === $block->getTemplate()) {
            $html = $event->getTransport()->getHtml();

            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xml = simplexml_import_dom($dom);    


            /* @var $formButtons SimpleXMLElement */
            $formButtons = current($xml->xpath('//div[@class=\'nav-bar\']'));
            $oaloginLink = $formButtons->addChild('a', Mage::helper('helpclient')->__('Mage training help guides'));
            $oaloginLink->addAttribute('class', 'page-helpclient');
            $oaloginLink->addAttribute('id', 'page-helpclient');
            $oaloginLink->addAttribute('href', 'javascript:void(0);');

            $html = $xml->saveXML();
            
            $event->getTransport()->setHtml($html);
        }
    }
}