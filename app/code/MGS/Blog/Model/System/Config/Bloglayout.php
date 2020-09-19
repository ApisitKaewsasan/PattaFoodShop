<?php
namespace MGS\Blog\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Bloglayout implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [ 
			['value' => 'blog_list', 'label' => __('Blog List')], 
			['value' => 'blog_masonry', 'label' => __('Blog Masonry')]
		];
    }
}
