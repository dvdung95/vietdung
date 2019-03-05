<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 05/03/2019
 * Time: 14:51
 */

namespace Vietdung\Blogg\Ui\Component\Listing\Columns;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ConfigTitle extends Column
{
    protected $storeManager;
    protected $urlInterface;
    public function __construct(ContextInterface $context,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                array $data = [],
                                StoreManagerInterface $storeManager,
                                UrlInterface $url)
    {
        $this->storeManager = $storeManager;
        $this->urlInterface = $url;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items']))
        foreach ($dataSource['data']['items']as & $item)
        {
            $name = $this->getData('name');
            if(isset($item['slug']))
            {
                $a = $item['title'];
                $url = $this->storeManager->getStore()->getBaseUrl()."blogg/".$item['slug'];
                $item['title'] = '<a href='.$url.'>'."$a".'</a>';
//                $url = $this->storeManager->getStore()->getBaseUrl()."/blogg/detail/".$item['id'];
//                $item[$name]['v'] = [
//                    'href' => $this->urlInterface->getUrl($url),
//                    'label' => __('View '.$item['id'])
//                ];
            }
        }

        return $dataSource;
    }
}