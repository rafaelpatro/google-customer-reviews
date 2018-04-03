<?php
class Quack_GoogleReviews_Block_Badge extends Mage_Core_Block_Template
{

    /**
     * Are both ga and badge available
     *
     * @return bool
     */
    protected function _isAvailable()
    {
        $enabled = Mage::helper('googlereviews')->isGoogleReviewsAvailable();
        $badgeVisible = Mage::helper('googlereviews')->isGoogleReviewsBadgeVisible();
        return ($enabled && $badgeVisible);
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
