<?php
class Ip_Prohibited_Model_Onepage extends Mage_Checkout_Model_Type_Onepage
{


    protected $Restricted_Countries = array(
        'GB', // Country Codes
        'CA'
    );

    protected $Restricted_Categories = array(
        20, // Category IDs
        30,
        40
    );

    protected $Error_Message = 'Shipping of these products are not available for this country.';

    public function saveShippingMethod($shippingMethod)
    {
        $quote = $this->getQuote();
        $country = $quote->getShippingAddress()->getCountry();
        if(in_array($country, $this->Restricted_Countries)){
            foreach ($quote->getAllItems() as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                foreach ($this->Restricted_Categories as $cat_id) {
                    if(in_array($cat_id, $product->getCategoryIds())){
                    	Mage::getSingleton('checkout/session')->addError($Error_Message);
		                Mage::throwException($Error_Message);
		                exit();
                    }
                }
            }
        }
    	return parent::saveShippingMethod($shippingMethod);
    }
}