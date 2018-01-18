<?php
class Quack_GoogleReviews_Block_Gr extends Mage_Core_Block_Template
{

    /**
     * Get a specific page name (may be customized via layout)
     *
     * @return string|null
     */
    public function getPageName()
    {
        return $this->_getData('page_name');
    }

    /**
     * Render information about specified orders and their reviews
     *
     * @return string
     */
    protected function _getOrdersReviews()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds));
        $result = array();
        $result[] = 'window.renderOptIn = function() {';
        $result[] = 'window.gapi.load("surveyoptin", function() {';
        foreach ($collection as $order) {
            /* @var $order Mage_Sales_Model_Order */
            $result[] = sprintf('window.gapi.surveyoptin.render(
                {
                    "merchant_id": %s,
                    "order_id": "%s",
                    "email": "%s",
                    "delivery_country": "%s",
                    "estimated_delivery_date": "%s",
                    "products": [%s]
                });',
                Mage::helper('googlereviews')->getAccountId(),
                $order->getIncrementId(),
                $order->getCustomerEmail(),
                Mage::helper('googlereviews')->getDeliveryCountryCode($order),
                Mage::helper('googlereviews')->getEstimatedDeliveryDate($order),
                Mage::helper('googlereviews')->getProductsGtin($order)
            );
        }
        $result[] = '});}';
        return implode("\n", $result);
    }

    /**
     * Is ga available
     *
     * @return bool
     */
    protected function _isAvailable()
    {
        return Mage::helper('googlereviews')->isGoogleReviewsAvailable();
    }

    /**
     * Render GA tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_isAvailable()) {
            return '';
        }
        return parent::_toHtml();
    }
}
