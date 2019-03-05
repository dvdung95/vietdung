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

//    protected $_template = "widget/posts.phtml";
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

    public function getBaseURLMedia()
    {
        $media = $this->_objmanager
                    ->get("Magento\Store\Model\StoreManagerInterface")
                    ->getStore()
                    ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $media;
    }
//    protected function _beforeToHtml()
//    {
////        $model = $this->_bloggCollectionFactory->create();
////        $blog = $model->setPagesize(3)->getData();
////        $this->setData("blog",$blog);
////        foreach ($this->getBlogList()->getData() as $blog)
////        {
////            var_dump($blog);
////            die;
////        }
////        var_dump($this->getBlogList());die;
//        echo $this->getBlogList()->getSelectSql()->__toString();die;
//        return parent::_beforeToHtml();
//    echo "<pre>";
//    var_dump($this->getBlogList());
//    die;
//    }
    public function getBlogList()
    {
        $blogg = $this->_bloggCollectionFactory->create();
//        $a = $blogg->getData();
        $blogg->setCurPage($this->getCurrentPage())->setPageSize(2);
        return $blogg;
    }

    public function getCurrentPage()
    {
        $request = $this->_request->getParam('page');
        if ($request) {
            $page = $request;
        } else {
            $page = 1;
        }
        return $page;
    }
    public function getPager(){
        $pager = $this->getChildBlock("blogg_list_pager");
        $pager->setTemplate("Vietdung_Blogg::pager.phtml");
        $pager->setPageVarName("page");
        $collection = $this->getBlogList();
        $pager->setAvailableLimit([2=>2]);
        $pager->setTotalNum($collection->getSize());
        $pager->setCollection($collection);
        $pager->setShowPerPage(TRUE);
        return  $pager->_toHtml();

    }
}