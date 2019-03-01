<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 14:55
 */

namespace Vietdung\Blogg\Ui\Component\Listing\Columns;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
class Thumbnail extends Column
{
    protected $_storeManager;
    protected $_url;
    public function __construct(ContextInterface $context,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                array $data = [],
                                StoreManagerInterface $storeManager,
                                UrlInterface $url)
    {

        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_url = $url;
    }
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            // Lấy ra tên cột hiển thị (ở đây là cột image)
            $fieldName = $this->getData('name' );

            // Sửa lại giá trị của data source
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';

                if ($item['image'] != '') {
                    // Lấy đường dẫn của ảnh
                    $url = $this->_storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . 'blogg/images/' . $item['image'];

                }

                /*
                * Truyền vào các giá trị cần thiết
                * $fieldName . '_src' - Đường dẫn của ảnh trong bảng
                * $fieldName . '_alt' - Giá trị thuộc tính alt của ảnh
                * $fieldName . '_link' - Link khi bấm vào ảnh (trỏ sang trang edit)
                * $fieldName . '_orig_src' - Đường dẫn ảnh khi phóng to
                */
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['image'];
                $item[$fieldName . '_link'] = $this->_url->getUrl('banner/index/edit', ['id' => $item['id']]);
                $item[$fieldName . '_orig_src'] = $url;
            }
        }
        return $dataSource;
    }
}