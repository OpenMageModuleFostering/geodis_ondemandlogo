<?php
class Geodis_Ondemandlogo_Model_Resource_Shippment extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('geodis_ondemandlogo/shippment', 'id');
    }
}