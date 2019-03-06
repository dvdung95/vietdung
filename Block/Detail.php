<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 06/03/2019
 * Time: 09:46
 */

namespace Vietdung\Blogg\Block;


use Magento\Framework\View\Element\Template;
use Vietdung\Blogg\Model\BloggFactory;
use Magento\Store\Model\StoreManagerInterface;

class Detail extends Template
{
    protected $bloggFactory;
    protected $storeManager;
   public function __construct(Template\Context $context,
                               array $data = [],
                               BloggFactory $bloggFactory,StoreManagerInterface $storeManager)
   {
       $this->storeManager = $storeManager;
       $this->bloggFactory = $bloggFactory;
       parent::__construct($context, $data);
   }
   public function getBlog(){
       $id = $this->_request->getParam('id');
       return $this->bloggFactory->create()->load($id);
   }
   public function getUrll(){
       $url = $this->storeManager->getStore()->getBaseUrl().'pub/media/blogg/images/';
       return $url;
   }
}