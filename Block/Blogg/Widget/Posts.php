<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 28/02/2019
 * Time: 17:15
 */

namespace Vietdung\Blogg\Block\Blogg\Widget;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Vietdung\Blogg\Model\ResourceModel\Blogg\CollectionFactory;
use Magento\Framework\ObjectManagerInterface;
class Posts extends Template implements BlockInterface
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

    protected function _beforeToHtml()
    {
//        echo $this->getData("recordshow");
        $ids = explode(",",$this->getData("recordshow"));
       $model = $this->_bloggCollectionFactory->create();
       $blog = $model->addFieldToFilter("id",["in"=>$ids])
           ->getData();
       $this->setData("blog",$blog);
        return parent::_beforeToHtml();
    }
    public function getBaseURLMedia(){
        $media = $this->_objmanager->get("Magento\Store\Model\StoreManagerInterface")
                        ->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $media;
    }

}