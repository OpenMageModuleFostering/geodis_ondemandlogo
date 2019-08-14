<?php

class Geodis_Ondemandlogo_Helper_Data extends Mage_Core_Helper_Abstract {

    const GEODIS_METHOD_1 = 'geodis_od_express';
    const GEODIS_METHOD_2 = 'geodis_od_messagerie';
    const GEODIS_METHOD_3 = 'geodis_rdv_tel_express';
    const GEODIS_METHOD_4 = 'geodis_rdv_tel_messagerie';
    const GEODIS_METHOD_1_NAME = 'GEODIS ON DEMAND premium';
    const GEODIS_METHOD_2_NAME = 'GEODIS ON DEMAND standard';
    const GEODIS_METHOD_3_NAME = 'GEODIS ON DEMAND live';
    
    const GEODIS_POIDS_MAX = 1000;
    
    const XML_GEODIS_METHOD_1_ACTIVE = 'carriers/geodis_methods/method_1_active';
    const XML_GEODIS_METHOD_1_DESCRIPTION = 'carriers/geodis_methods/method_1_description';
    const XML_GEODIS_METHOD_1_LONG_DESCRIPTION = 'carriers/geodis_methods/method_1_longDescription';
    const XML_GEODIS_METHOD_1_PRICE = 'carriers/geodis_methods/method_1_price';
    const XML_GEODIS_METHOD_2_ACTIVE = 'carriers/geodis_methods/method_2_active';
    const XML_GEODIS_METHOD_2_DESCRIPTION = 'carriers/geodis_methods/method_2_description';
    const XML_GEODIS_METHOD_2_LONG_DESCRIPTION = 'carriers/geodis_methods/method_2_longDescription';
    const XML_GEODIS_METHOD_2_PRICE = 'carriers/geodis_methods/method_2_price';
    const XML_GEODIS_METHOD_3_ACTIVE = 'carriers/geodis_methods/method_3_active';
    const XML_GEODIS_METHOD_3_DESCRIPTION = 'carriers/geodis_methods/method_3_description';
    const XML_GEODIS_METHOD_3_LONG_DESCRIPTION = 'carriers/geodis_methods/method_3_longDescription';
    const XML_GEODIS_METHOD_3_PRICE = 'carriers/geodis_methods/method_3_price';
 

    protected $geodisDestinationCountryMethod1 = array(1 => 'FR', 2 => 'MC');
    protected $geodisDestinationCountryMethod2 = array(1 => 'FR', 2 => 'MC', 3 => 'BE', 4 => 'LU');
    protected $geodisDestinationCountryMethod3 = array(1 => 'FR', 2 => 'MC', 3 => 'BE', 4 => 'LU');

    public function getGeodisMethod1() {
        return self::GEODIS_METHOD_1;
    }

    public function getGeodisMethod2() {
        return self::GEODIS_METHOD_2;
    }

    public function getGeodisMethod3() {
        return self::GEODIS_METHOD_3;
    }


    public function getGeodisMethod1Name() {
        return self::GEODIS_METHOD_1_NAME;
    }

    public function getGeodisMethod2Name() {
        return self::GEODIS_METHOD_2_NAME;
    }

    public function getGeodisMethod3Name() {
        return self::GEODIS_METHOD_3_NAME;
    }

    public function getMethod1IsActive() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_1_ACTIVE);
    }

    public function getMethod1Description() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_1_DESCRIPTION);
    }

    public function getMethod1LongDescription() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_1_LONG_DESCRIPTION);
    }

    public function getMethod1Price() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_1_PRICE);
    }

    /*     * *************************************************************************************************************** */

    public function getMethod2IsActive() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_2_ACTIVE);
    }

    public function getMethod2Description() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_2_DESCRIPTION);
    }

    public function getMethod2LongDescription() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_2_LONG_DESCRIPTION);
    }

    public function getMethod2Price() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_2_PRICE);
    }

    /*     * *************************************************************************************************************** */

    public function getMethod3IsActive() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_3_ACTIVE);
    }

    public function getMethod3Description() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_3_DESCRIPTION);
    }

    public function getMethod3LongDescription() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_3_LONG_DESCRIPTION);
    }

    public function getMethod3Price() {
        return Mage::getStoreConfig(self::XML_GEODIS_METHOD_3_PRICE);
    }


    /*     * ************************************************************************************************************** */

    // verify if shipping method is enabled 
    public function verifyShippingDisponibility() {

        $return = array();
         $items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        $PackageWeight = 0;
        foreach ($items as $item) {
            if (($item->getProductType() == "configurable") || ($item->getProductType() == "grouped")) {
                $PackageWeight += ($item->getWeight() * (((int) $item->getQty()) - 1));
            } else {
                $PackageWeight += ($item->getWeight() * ((int) $item->getQty()));
            }
        }
        
        $customerAdressCountryCode = $this->getCustomerCountry();
        //verify destination country
        $keyOdExpressDestinationCountry = array_search($customerAdressCountryCode, $this->geodisDestinationCountryMethod1);
        $keyOdMessagerieDestinationCountry = array_search($customerAdressCountryCode, $this->geodisDestinationCountryMethod2);
        $keyRdvTelExpressDestinationCountry = array_search($customerAdressCountryCode, $this->geodisDestinationCountryMethod3);
        
        if ($keyOdExpressDestinationCountry && ($PackageWeight < self::GEODIS_POIDS_MAX)) {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_1] = 1;
        } else {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_1] = 0;
        }

        if ($keyOdMessagerieDestinationCountry && ($PackageWeight < self::GEODIS_POIDS_MAX)) {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_2] = 1;
        } else {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_2] = 0;
        }

        if ($keyRdvTelExpressDestinationCountry && ($PackageWeight < self::GEODIS_POIDS_MAX)) {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_3] = 1;
        } else {
            $return['s_method_geodis_ondemandlogo_' . self::GEODIS_METHOD_3] = 0;
        }

        return $return;
    }
    
    public function getCustomerCountry(){
         if (Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping()) {
            $customerAdressCountryCode = Mage::getSingleton('checkout/type_onepage')->getQuote()->getShippingAddress()->getCountryId();
        } else {
            $customerAdressCountryCode = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getCountryId();
        }
        return $customerAdressCountryCode;
    }

}
