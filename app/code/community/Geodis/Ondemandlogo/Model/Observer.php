<?php

class Geodis_Ondemandlogo_Model_Observer {

    public function saveShippingMethod($evt) {
        $request = $evt->getRequest();
        $quote = $evt->getQuote();
        $params = $request->getParams();
        $shippingMethode = $params['shipping_method'];
        $formInformations = $params[$shippingMethode];
        $formInformations['shipping_methode'] = $shippingMethode;
        $quote_id = $quote->getId();
        $data = array($quote_id => $formInformations);
        $data['shipping_methode'] = $shippingMethode;
        if ($formInformations && strpos($formInformations['shipping_methode'], 'geodis_ondemandlogo') !== false) {
            Mage::getSingleton('checkout/session')->setFormInformation($data);
        }
    }

    public function saveOrderAfter($evt) {
        $order = $evt->getOrder();
        $quote = $evt->getQuote();
        $quote_id = $quote->getId();
        $formInformations = Mage::getSingleton('checkout/session')->getFormInformation();
            $collection = Mage::getModel('geodis_ondemandlogo/shippment');
            if (isset($formInformations[$quote_id])) {
                $data = $formInformations[$quote_id];
                $data['order_id'] = $order->getId();
                $collection->setData('order_id', $order->getId())
                        ->setData('store', Mage::app()->getStore()->getStoreId());
                if (isset($formInformations[$quote_id]['email'])) {
                    $collection->setData('email', $formInformations[$quote_id]['email']);
                }
                if (isset($formInformations[$quote_id]['phone'])) {
                    $collection->setData('phone', $formInformations[$quote_id]['phone']);
                }
                if (isset($formInformations[$quote_id]['mobile'])) {
                    $collection->setData('mobile', $formInformations[$quote_id]['mobile']);
                }
                $collection->save();
            }
    }

    public function loadOrderAfter($evt) {
        $order = $evt->getOrder();
        if ($order->getId()) {
            $order_id = $order->getId();
            $shippingCollection = Mage::getModel('geodis_ondemandlogo/shippment')->getCollection();
            $shippingCollection->addFieldToFilter('order_id', $order_id);
            $userInformation = $shippingCollection->getFirstItem();
            $order->setGeodisObject($userInformation);
        }
    }

    public function salesOrderGridCollectionLoadBefore($observer) {
        
        $collection = $observer->getOrderGridCollection();
        $select = $collection->getSelect();
        $select->join('sales_flat_order', 'main_table.entity_id = sales_flat_order.entity_id', array('shipping_description'));
        
    }

}
