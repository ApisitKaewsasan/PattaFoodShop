<?php
namespace MGS\Blog\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Blogcols implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
			['value' => '2', 'label' => __('2 columns')], 
			['value' => '3', 'label' => __('3 columns')]
		];
    }
}
