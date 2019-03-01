<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 16:17
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Vietdung\Blogg\Model\BloggFactory;

class Edit extends Action
{
    protected $_pageFactory;
    protected $_bloggFactory;

    public function __construct(Action\Context $context, PageFactory $pageFactory, BloggFactory $bloggFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_bloggFactory = $bloggFactory;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_pageFactory->create();
        $resultPage->setActiveMenu('Vietdung_Blogg::blog');
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_bloggFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }
        $rsPage = $this->_initAction();
        $rsPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Blog') : __('New Blog'));
        return $rsPage;
    }
}