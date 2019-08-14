<?php

class Geodis_Ondemandlogo_Model_Sales_Order extends Mage_Sales_Model_Order {

    //add geodis shipping information to order view 
    public function getShippingDescription() {
        $desc = parent::getShippingDescription();
        $geodisObject = $this->getGeodisObject();
        //print_r('geodis : '.$geodisObject);//die();
        //Mage::log($geodisObject->getEmail());
        if ($geodisObject) {
            $desc .= " | ";
            if ($geodisObject->getPhone()) {
                $desc .= "Tél: " . $geodisObject->getPhone() . " | ";
            }
            if ($geodisObject->getMobile()) {
                $desc .= "Mobile : " . $geodisObject->getMobile() . " | ";
            }
            if ($geodisObject->getEmail()) {
                $desc .= "Email : " . $geodisObject->getEmail() . "";
            }
        }

        return $desc;
    }

}
