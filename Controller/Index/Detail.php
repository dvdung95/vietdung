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

class Detail extends Action
{
    protected $bloggFactory;
    protected $pageFactory;
    public function __construct(Context $context,
                                PageFactory $pageFactory,
                                BloggFactory $bloggFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->bloggFactory = $bloggFactory;
        parent::__construct($context);
    }

    public function execute()
   {
        $param =$this->_request->getParam();
        $blogg = $this->bloggFactory->create()->load($param['id']);
        $resultPage =$this->pageFactory->create();
        return$resultPage;
   }
}