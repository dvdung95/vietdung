<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 11:37
 */

namespace Vietdung\Blogg\Model;


use Magento\Framework\Model\AbstractModel;

class Blogg extends AbstractModel
{
    protected function _construct()
    {
        $this->_init("Vietdung\Blogg\Model\ResourceModel\Blogg");
    }
}