<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 01/03/2019
 * Time: 15:57
 */

namespace Vietdung\Blogg\Block;
use Magento\Framework\UrlInterface;
use Vietdung\Blogg\Model\ResourceModel\Blogg\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\ObjectManagerInterface;
class Blogg extends Template
{
    protected $_bloggCollectionFactory;
    protected $_objmanager;
    protected $_template = "widget/posts.phtml";
    public function __construct(Template\Context $context,
                                CollectionFactory $collectionFactory,
                                ObjectManagerInterface $objectManager,
                                array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_bloggCollectionFactory = $collectionFactory;
        $this->_objmanager = $objectManager;
    }
    public function getBaseURLMedia(){
        $media = $this->_objmanager->get("Magento\Store\Model\StoreManagerInterface")
            ->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $media;
    }
    protected function _beforeToHtml()
    {
        $model = $this->_bloggCollectionFactory->create();
        $blog = $model->getData();
        $this->setData("blog",$blog);
        return parent::_beforeToHtml();
    }
}