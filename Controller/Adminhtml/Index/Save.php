<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 16:47
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Vietdung\Blogg\Model\BloggFactory;
use Vietdung\Blogg\Model\Blogg;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Vietdung\Blogg\Controller\Adminhtml\Index\PostDataProcessor;

class Save extends Action
{

    protected $bloggFactory;
    protected $dataProcessor;
    protected $dataPersistor;

    const ADMIN_RESOURCE = 'Vietdung_Staff::save';

    public function __construct(Action\Context $context,
                                BloggFactory $bloggFactory,
                                PostDataProcessor $dataProcessor,
                                DataPersistorInterface $dataPersistor)
    {

        $this->bloggFactory = $bloggFactory;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }


    protected function _filterBannerPostData(array $rawData): array
    {
        $data = $rawData;
        if (isset($data['image']) && is_array($data['image'])) {
            if (!empty($data['image']['delete'])) {
                $data['image'] = null;
            } else {
                if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                    $data['image'] = $data['image'][0]['name'];
                } else {
                    unset($data['image']);
                }
            }
        }
        return $data;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $model = $this->bloggFactory->create();


        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (empty($data['image'])) {
                $data['image'] = null;
            }
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                try {
                    $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                    return $this->_redirect('*/*/');
                }
            }

            $model->setData($this->_filterBannerPostData($data));
            $this->messageManager->addSuccess(__('You saved the staff.'));

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the staff.'));
                $this->dataPersistor->clear('staff');
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.' . $e->getMessage()));
            }
            $this->dataPersistor->set('staff', $data);
            if ($this->getRequest()->getParam('id')) {
                return $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
            return $this->_redirect('*/*/add');

        }
        // Redirect to List page
        return $this->_redirect('*/*/');


    }
}