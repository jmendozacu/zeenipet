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
class AdjustWare_Deliverydate_Block_Container extends Mage_Core_Block_Template
{
    private $_store = null;

    public function setInAdminOrderStore($store)
    {
        $this->_store = $store;
    }
    
    public function getFields(){
        return Mage::getModel('adjdeliverydate/step')->getFields($this->_store);
    }

    public function getFormsFields($_index){
        return Mage::getModel('adjdeliverydate/step')->getFormsFields($_index);
    }
    
    public function getForms($_index)
    {
    	$sHtml='';
    	$sHtml.=$this->getChildHtml('availablecopy');
		$sHtml.='<ul>';
		foreach($this->getFormsFields($_index) as $field)
		{
	    	$sHtml.='<li>
	        <div class="input-box">'.
			$field->getHtml().'
			<div>
			</li>';
		}
		$sHtml.='</ul>'; 
		return  $sHtml;
    }
   
}
?>