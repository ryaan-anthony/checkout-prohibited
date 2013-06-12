<?php
class Ip_Prohibited_Model_Onepage extends Aitoc_Aitcheckout_Model_Rewrite_Checkout_Type_Onepage
{


    protected $Restricted_Countries = array(
        'GB',
        'CA',
        'RU',
        'BR',
        'MX',
        'SA',
        'UA',
        'DE',
        'SE',
        'FR',
        'KZ',
        'IE',
        'LY',
        'IL',
        'NL',
        'CH',
        'KW',
      	'MD',
      	'QA',
      	'BH'
    );

    protected $Restricted_Categories = array(
        56
    );

    public function saveShippingMethod($shippingMethod)
    {
        $quote = $this->getQuote();
        $country = $quote->getShippingAddress()->getCountry();
        if(in_array($country, $this->Restricted_Countries)){
            foreach ($quote->getAllItems() as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                foreach ($this->Restricted_Categories as $cat_id) {
                    if(in_array($cat_id, $product->getCategoryIds())){
                    	Mage::getSingleton('checkout/session')->addError('Shipping of JOVANI dresses is not available for this country.');
		                Mage::throwException("Checkout Disabled");
		                exit();
                    }
                }
            }
        }
    	return parent::saveShippingMethod($shippingMethod);
    }
}