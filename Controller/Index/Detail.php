<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 05/03/2019
 * Time: 14:22
 */

namespace Vietdung\Blogg\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vietdung\Blogg\Model\BloggFactory;
use Magento\Framework\UrlInterface;

class Detail extends Action
{
    protected $bloggFactory;
    protected $pageFactory;
    protected $url;
    public function __construct(Context $context,
                                PageFactory $pageFactory,
                                BloggFactory $bloggFactory,
                                UrlInterface $url)
    {
        $this->pageFactory = $pageFactory;
        $this->bloggFactory = $bloggFactory;
        $this->url = $url;
        parent::__construct($context);
    }

    public function execute()
   {

        $params =$this->_request->getParams();
        $blogg = $this->bloggFactory->create()->load($params['id']);
        if(!$blogg->getId()){
            $this->_redirect('no-router');
        }
        $resultPage =$this->pageFactory->create();
        return$resultPage;
   }
}