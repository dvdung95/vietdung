<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 11:39
 */

namespace Vietdung\Blogg\Model\ResourceModel;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Vietdung\Blogg\Model\ResourceModel\Blogg\CollectionFactory;

class Blogg extends AbstractDb
{
    protected $collectionFactory;
   public function __construct(Context $context,CollectionFactory $collectionFactory,$connectionName = null)
   {
       parent::__construct($context, $connectionName);
       $this->collectionFactory = $collectionFactory;
   }

    protected function _construct()
    {
        $this->_init("blogg","id");
    }
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');

        if ($image != null) {
            $imageUploader = ObjectManager::getInstance()->create("Vietdung\Blogg\BloggImageUpload");
            $imageUploader->moveFileFromTmp($image);
        }
        return $this;
    }
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $slug = $object->getData('slug');
        $start_date= $object->getData('start_date');
        $end_date = $object->getData('end_date');

        $model = $this->collectionFactory->create();
        if($object->getData('id') == ''){
            foreach ($model as $blog)
            {
                if($slug==$blog['slug'])
                {
                    throw new LocalizedException(__('Slug đã tồn tại vui lòng điền thông tin khác'));
                }
            }
        }
        if (strtotime($start_date) >= strtotime($end_date)) {
            throw new LocalizedException(__('Ngày kết thúc phải sau ngày bất đầu - Vui lòng chọn lại'));
        }
        return $this;
    }
}