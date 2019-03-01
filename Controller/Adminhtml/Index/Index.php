<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 11:42
 */
namespace Vietdung\Blogg\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_pageFactory;
    public function __construct(Action\Context $context,PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
    }
    public function execute()
    {
        $rsPage = $this->_pageFactory->create();
        $rsPage->setActiveMenu('Vietdung_Blogg::blog');
        $rsPage->getConfig()->getTitle()->prepend(__("Blog Manager"));
        return $rsPage;
    }
}