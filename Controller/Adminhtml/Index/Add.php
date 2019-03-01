<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 16:09
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Add extends Action
{
    protected $resultForwardFactory;
    public function __construct(Action\Context $context ,ForwardFactory $resultForwardFactory)
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $rsForward = $this->resultForwardFactory->create();
        return $rsForward->forward("edit");
    }
}