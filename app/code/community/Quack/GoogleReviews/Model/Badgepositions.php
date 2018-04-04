<?php
class Quack_GoogleReviews_Model_Badgepositions {

    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'BOTTOM_RIGHT',
                'label' => 'In the bottom right (default)',
            ),
            array(
                'value' => 'BOTTOM_LEFT',
                'label' => 'In the bottom left',
            ),
            array(
                'value' => 'INLINE',
                'label' => 'In the place (inline)',
            ),
        );
    }
}