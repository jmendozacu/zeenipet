<?php
/**
 * Delivery Date
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Deliverydate
 * @version      1.1.7
 * @license:     CGRl40OoIpwl63Yy9HmSwXtQ6ZlFDRlIXEc7HbfxdJ
 * @copyright:   Copyright (c) 2013 AITOC, Inc. (http://www.aitoc.com)
 */
/**
 * @author Adjustware
 */ 
class AdjustWare_Deliverydate_Model_Mysql4_Holiday extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('adjdeliverydate/holiday', 'holiday_id');
    }
}