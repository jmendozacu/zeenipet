<?php

class Indies_Partialpayment_Model_Partialpayment extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('partialpayment/partialpayment');
    }
}