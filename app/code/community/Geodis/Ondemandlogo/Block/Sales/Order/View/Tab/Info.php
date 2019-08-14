<?php

class Geodis_Ondemandlogo_Block_Sales_Order_View_Tab_Info extends Mage_Adminhtml_Block_Sales_Order_View_Tab_Info {

    /**
     * 
     * get geodis shipping information
     */
    public function getGeodisShippingInformations() {
        $order_id = $this->getOrder()->getId();
        $shippingCollection = Mage::getModel('geodis_ondemandlogo/shippment')->getCollection()->addFieldToFilter('order_id', $order_id);
        return $shippingCollection->getFirstItem();
    }
}
