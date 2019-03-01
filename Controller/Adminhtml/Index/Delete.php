<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 28/02/2019
 * Time: 13:32
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Vietdung\Blogg\Model\BloggFactory;

class Delete extends Action
{
    protected $_bloggFactory;
    public function __construct(Action\Context $context,BloggFactory $bloggFactory)
    {
        $this->_bloggFactory = $bloggFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $rsRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam("id");
        if ($id) {
            try {
                // init model and delete
                $model = $this->_bloggFactory->create();
                try{
                    $model->load($id);
                }catch (\Exception $e){
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the block.'));
                // go to grid
                return $rsRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $rsRedirect->setPath('*/*/');
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a block to delete.'));
        // go to grid
        return $rsRedirect->setPath('*/*/');
    }
}