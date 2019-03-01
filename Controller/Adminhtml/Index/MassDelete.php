<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 28/02/2019
 * Time: 15:53
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Vietdung\Blogg\Model\ResourceModel\Blogg\CollectionFactory;
use Magento\Backend\App\Action;

class MassDelete extends Action
{
    protected $filter;
    protected $collectionFactory;
    public function __construct(Action\Context $context,Filter $filter,CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {

        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $collectionSize = $collection->getSize();

        // Xóa bản ghi đang chọn
        foreach ($collection as $banner) {
            $banner->delete();
        }

        // Thêm thông báo xóa thành công
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        // Redirect lại về trang List
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}