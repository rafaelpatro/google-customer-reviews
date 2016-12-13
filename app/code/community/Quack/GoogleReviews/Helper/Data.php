<?php

class Quack_GoogleReviews_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    const XML_PATH_ACCOUNT = 'google/reviews/account';
    
    const XML_PATH_ENABLED = 'google/reviews/active';
    
    const XML_PATH_COUNTRY_CODE = 'google/reviews/country_code';
    
    const XML_PATH_ESTIMATED_DELIVERY_TIME = 'google/reviews/estimated_delivery_time';
    
    /**
     * Get Google Merchant account id
     *
     * @param string $store
     * @return string
     */
    public function getAccountId($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ACCOUNT, $store);
    }
    
    public function getEstimatedDeliveryTime($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ESTIMATED_DELIVERY_TIME, $store);
    }
    
    /**
     * 
     * @param Mage_Sales_Model_Order $order
     * 
     * @return string
     */
    public function getEstimatedDeliveryDate($order)
    {
        $_pattern = $this->getEstimatedDeliveryTime();
        $_time = empty($_pattern) ? 0 : $_pattern;
        if ( !is_numeric($_time) ) {
            if ( preg_match($_pattern, $order->getShippingDescription(), $matches) ) {
                $_time = (int)$matches[1][0];
            }
        }
        $_estimatedDate = new DateTime();
        $_estimatedDate->add(new DateInterval("P{$_time}D"));
        return $_estimatedDate->format('Y-m-d');
    }
    
    public function isGoogleReviewsAvailable($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
    
    public function getDeliveryCountryCode($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_COUNTRY_CODE, $store);
    }
}
