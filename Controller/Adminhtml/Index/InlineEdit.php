<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 28/02/2019
 * Time: 14:38
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Vietdung\Blogg\Model\BloggFactory;

class InlineEdit extends Action
{
    protected $_jsonFactory;
    protected $_bloggFactory;
    public function __construct(Action\Context $context,JsonFactory $jsonFactory,BloggFactory $bloggFactory)
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_bloggFactory = $bloggFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $rsJson = $this->_jsonFactory->create();
        $message = [];
        $error = false;

        $postItems = $this->getRequest()->getParam('items');


        foreach (array_keys($postItems) as $bloggId) {

            try {
                $staff = $this->_bloggFactory->create();
                $staff->load($bloggId);
                $staff->setData($postItems[(string)$bloggId]);
                $staff->save();
            } catch (\Exception $e) {
                $message[] = __('Something Went Wrong');
                $error = true;
            }
        }
        return $rsJson->setData([
            'message' => $message,
            'error' => $error
        ]);
    }
}