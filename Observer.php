<?php
class Eagle_AdditionalOptions_Model_Observer
{
	public function catalogProductLoadAfter(Varien_Event_Observer $observer)
	{
		
		$action = Mage::app()->getFrontController()->getAction();
		
		if ($action->getFullActionName() == 'checkout_cart_add')
    	{

    		// assuming you are posting your custom form values in an array called extra_options...
        	if ($options = $action->getRequest()->getParam('extra_options'))
        	{
        		

	        	$product = $observer->getProduct();

	            // add to the additional options array
	            $additionalOptions = array();



	            // if ($additionalOption = $product->getCustomOption('additional_options'))
	            // {
	            //     $additionalOptions = (array) unserialize($additionalOption->getValue());
	            // }

	            foreach ($options as $key => $value)
	            {
	                $additionalOptions[] = array(
	                    'label' => $key,
	                    'value' => $value,
	                );
	            }
	            // add the additional options array with the option code additional_options
	            $observer->getProduct()
	                ->addCustomOption('additional_options', serialize($additionalOptions));

	            foreach ($additionalOptions as $key => $value)
	            {
	                $string .= "[$key] = $value | ";
	            }
	                $a = count($additionalOptions);

        		    Mage::log(
		            "cont = $a, $string",
		            null, 
		            'product-updates.log',
		            true 
	        	);

        	}
        	else
        	{
        		Mage::log(
		            "EMPTY",
		            null, 
		            'product-updates.log',
		            true 
	        	);
        	}

		
		}
    }


}
?>