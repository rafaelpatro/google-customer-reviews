<?php

class Quack_GoogleReviews_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    const XML_PATH_ACCOUNT = 'google/reviews/account';
    
    const XML_PATH_ENABLED = 'google/reviews/active';
    
    const XML_PATH_COUNTRY_CODE = 'google/reviews/country_code';
    
    const XML_PATH_ESTIMATED_DELIVERY_TIME = 'google/reviews/estimated_delivery_time';
    
    const XML_PATH_ESTIMATED_DELIVERY_PATTERN = 'google/reviews/estimated_delivery_pattern';
    
    const XML_PATH_ATTRIBUTE_GTIN = 'google/reviews/attribute_gtin';
    
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

    public function getEstimatedDeliveryPattern($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ESTIMATED_DELIVERY_PATTERN, $store);
    }
    
    public function getAttributeGtin($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ATTRIBUTE_GTIN, $store);
    }
    
    /**
     * 
     * @param Mage_Sales_Model_Order $order
     * 
     * @return string
     */
    public function getEstimatedDeliveryDate($order)
    {
        $_time = $this->getEstimatedDeliveryTime();
        $_pattern = $this->getEstimatedDeliveryPattern();
        if ( !empty($_pattern) ) {
            if ( preg_match($_pattern, $order->getShippingDescription(), $matches, PREG_OFFSET_CAPTURE) ) {
                $_time = (int)$matches[1][0];
            }
        }
        $_time = is_numeric($_time) ? $_time : 0;
        $_estimatedDate = new DateTime();
        $_estimatedDate->add(new DateInterval("P{$_time}D"));
        return $_estimatedDate->format('Y-m-d');
    }
    
    public function isGoogleReviewsAvailable($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
    
    /**
     *
     * @param Mage_Sales_Model_Order $order
     * @param int $store
     *
     * @return string
     */
    public function getDeliveryCountryCode($order, $store = null)
    {
        $country = Mage::getStoreConfig(self::XML_PATH_COUNTRY_CODE, $store);
        if ($order->getShippingAddress() && $order->getShippingAddress()->getCountryId()) {
            $country = $order->getShippingAddress()->getCountryId();
        } elseif ($order->getBillingAddress() && $order->getBillingAddress()->getCountryId()) {
            $country = $order->getBillingAddress()->getCountryId();
        }
        return $country;
    }
    
    public function getProductsGtin($order, $store = null)
    {
        $response = array();
        foreach ($order->getAllItems() as $item) {
            if ($data = $item->getProduct()->getData($this->getAttributeGtin($store))) {
                if ($gtin = preg_replace('/\D/', '', $data)) {
                    $response[] = sprintf('{"gtin":"%s"}', $gtin);
                }
            }
        }
        return implode(", ", $response);
    }
}
