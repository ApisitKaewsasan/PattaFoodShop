<?php

namespace MGS\Brand\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_storeManager;
    protected $_config = [];
    protected $_filterProvider;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider
    )
    {
        parent::__construct($context);
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
    }

    public function getConfig($key, $store = null)
    {
        if ($store == null || $store == '') {
            $store = $this->_storeManager->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);
        $config = $this->scopeConfig->getValue(
            'brand/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $config;
    }

    public function getBaseMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getBrandUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->getConfig('general_settings/route');
    }

    public function filter($str)
    {
        $html = $this->_filterProvider->getPageFilter()->filter($str);
        return $html;
    }
	
	public function convertPerRowtoCol($perRow){
		switch ($perRow) {
            case 1:
                $result = 12;
                break;
            case 2:
                $result = 6;
                break;
            case 3:
                $result = 4;
                break;
            case 4:
                $result = 3;
                break;
            case 5:
                $result = 'custom-5';
                break;
            case 6:
                $result = 2;
			case 7:
                $result = 'custom-7';
			case 8:
                $result = 'custom-8';
                break;
        }
		
		return $result;
	}
	
	public function convertColClass($col, $type){
		if(($type=='row') && ($col=='custom-5' || $col=='custom-7' || $col=='custom-8')){
			return 'row-'.$col;
		}
		if($type=='col'){
			if(($col=='custom-5' || $col=='custom-7' || $col=='custom-8')){
				return 'col-md-'.$col;
			}else{
				$class = 'col-lg-'.$col.' col-md-'.$col;
				if(($col==12) || ($col==6)){
					$class .= ' col-sm-12 col-xs-12';
				}
				if(($col==4) || ($col==3)){
					$class .= ' col-sm-6 col-xs-6';
				}
				if($col==2){
					$class .= ' col-sm-4 col-xs-6';
				}
				
				return $class;
			}
		}
	}

}