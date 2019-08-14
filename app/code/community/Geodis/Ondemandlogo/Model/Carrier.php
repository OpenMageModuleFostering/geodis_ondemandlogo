<?php

class Geodis_Ondemandlogo_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'geodis_ondemandlogo';
    protected $geodisOriginCountryMethod1 = array(1 => 'FR', 2 => 'MC');
    protected $geodisOriginCountryMethod2 = array(1 => 'FR', 2 => 'MC', 3 => 'BE');
    protected $geodisOriginCountryMethod3 = array(1 => 'FR', 2 => 'MC', 3 => 'BE');

   /**
     * 
     * @return boolean 
     */
    public function getFormBlock() {
        return TRUE;
    }

    /**
     * Returns available shipping rates for Geodis Ondemandlogo carrier
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {

        $_shippingDisponibility = Mage::helper('geodis_ondemandlogo')->verifyShippingDisponibility();


        $method1 = Mage::helper('geodis_ondemandlogo')->getGeodisMethod1();
        $method2 = Mage::helper('geodis_ondemandlogo')->getGeodisMethod2();
        $method3 = Mage::helper('geodis_ondemandlogo')->getGeodisMethod3();

        $originCountryCode = Mage::getStoreConfig('shipping/origin/country_id');

        $keyOdExpressOriginCountry = array_search($originCountryCode, $this->geodisOriginCountryMethod1);
        $keyOdMessagerieOriginCountry = array_search($originCountryCode, $this->geodisOriginCountryMethod2);
        $keyRdvTelExpressOriginCountry = array_search($originCountryCode, $this->geodisOriginCountryMethod3);

        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        if ($keyOdExpressOriginCountry && Mage::helper('geodis_ondemandlogo')->getMethod1Price() !== '' && Mage::helper('geodis_ondemandlogo')->getMethod1Price() !== NULL && Mage::helper('geodis_ondemandlogo')->getMethod1Price() >= 0 && Mage::helper('geodis_ondemandlogo')->getMethod1IsActive()) {
            if (Mage::app()->getRequest()->getControllerName() == 'cart') {
                if ($_shippingDisponibility['s_method_geodis_ondemandlogo_' . $method1] != 0) {
                    $result->append($this->_getMethod1Rate());
                }
            } else {
                $result->append($this->_getMethod1Rate());
            }
        }
        if ($keyOdMessagerieOriginCountry && Mage::helper('geodis_ondemandlogo')->getMethod2Price() !== '' && Mage::helper('geodis_ondemandlogo')->getMethod2Price() !== NULL && Mage::helper('geodis_ondemandlogo')->getMethod2Price() >= 0 && Mage::helper('geodis_ondemandlogo')->getMethod2IsActive()) {
            if (Mage::app()->getRequest()->getControllerName() == 'cart') {
                if ($_shippingDisponibility['s_method_geodis_ondemandlogo_' . $method2] != 0) {
                    $result->append($this->_getMethod2Rate());
                }
            } else {
                $result->append($this->_getMethod2Rate());
            }
        }
        if ($keyRdvTelExpressOriginCountry && Mage::helper('geodis_ondemandlogo')->getMethod3Price() !== '' && Mage::helper('geodis_ondemandlogo')->getMethod3Price() !== NULL && Mage::helper('geodis_ondemandlogo')->getMethod3Price() >= 0 && Mage::helper('geodis_ondemandlogo')->getMethod3IsActive()) {
            if (Mage::app()->getRequest()->getControllerName() == 'cart') {
                if ($_shippingDisponibility['s_method_geodis_ondemandlogo_' . $method3] != 0) {
                    $result->append($this->_getMethod3Rate());
                }
            } else {
                $result->append($this->_getMethod3Rate());
            }
        }

        return $result;
    }

    /**
     * Returns Allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods() {
        return array(
            Mage::helper('geodis_ondemandlogo')->getGeodisMethod1() => Mage::helper('geodis_ondemandlogo')->getGeodisMethod1(),
            Mage::helper('geodis_ondemandlogo')->getGeodisMethod2() => Mage::helper('geodis_ondemandlogo')->getGeodisMethod2(),
            Mage::helper('geodis_ondemandlogo')->getGeodisMethod3() => Mage::helper('geodis_ondemandlogo')->getGeodisMethod3(),
        );
    }

    /**
     * Get On Demand Epress rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getMethod1Rate() {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle('Geodis On Demand Logo');
        $rate->setMethod(Mage::helper('geodis_ondemandlogo')->getGeodisMethod1());
        $rate->setMethodTitle(Mage::helper('geodis_ondemandlogo')->getGeodisMethod1Name());
        $rate->setMethodDescription(Mage::helper('geodis_ondemandlogo')->getMethod1Description());
        $rate->setPrice(Mage::helper('geodis_ondemandlogo')->getMethod1Price());
        $rate->setCost(Mage::helper('geodis_ondemandlogo')->getMethod1Price());


        return $rate;
    }

    /**
     * Get On Demand Messagerie rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getMethod2Rate() {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle('Geodis');
        $rate->setMethod(Mage::helper('geodis_ondemandlogo')->getGeodisMethod2());
        $rate->setMethodTitle(Mage::helper('geodis_ondemandlogo')->getGeodisMethod2Name());
        $rate->setMethodDescription(Mage::helper('geodis_ondemandlogo')->getMethod2Description());
        $rate->setPrice(Mage::helper('geodis_ondemandlogo')->getMethod2Price());
        $rate->setCost(Mage::helper('geodis_ondemandlogo')->getMethod2Price());

        return $rate;
    }

    /**
     * Get Appointment Express Phone rate object
     *
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getMethod3Rate() {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle('Geodis');
        $rate->setMethod(Mage::helper('geodis_ondemandlogo')->getGeodisMethod3());
        $rate->setMethodTitle(Mage::helper('geodis_ondemandlogo')->getGeodisMethod3Name());
        $rate->setMethodDescription(Mage::helper('geodis_ondemandlogo')->getMethod3Description());
        $rate->setPrice(Mage::helper('geodis_ondemandlogo')->getMethod3Price());
        $rate->setCost(Mage::helper('geodis_ondemandlogo')->getMethod3Price());

        return $rate;
    }

}
