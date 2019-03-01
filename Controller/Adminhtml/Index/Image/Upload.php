<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 28/02/2019
 * Time: 09:50
 */

namespace Vietdung\Blogg\Controller\Adminhtml\Index\Image;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Upload extends Action
{
    protected $imageUploader;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vietdung_Blogg::save');
    }


    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}