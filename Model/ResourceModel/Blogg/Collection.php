<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 11:41
 */

namespace Vietdung\Blogg\Model\ResourceModel\Blogg;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    public function _construct()
    {
        $this->_init("Vietdung\Blogg\Model\Blogg","Vietdung\Blogg\Model\ResourceModel\Blogg");
    }
}