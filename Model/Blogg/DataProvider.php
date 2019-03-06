<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 17:15
 */

namespace Vietdung\Blogg\Model\Blogg;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Vietdung\Blogg\Model\ResourceModel\Blogg\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bloggCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {

        $this->collection = $bloggCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->storeManager = $storeManager;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */

    public function getData()
    {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        foreach ($items as $blogg) {
            $data = $blogg->getData();

            $image = $data['image'];
            unset($data['image']);
            $data['image'][0]['url'] = $this->storeManager->getStore()->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ).'blogg/images/' .$image;

            $data['image'][0]['name'] = $image;
            $this->loadedData[$blogg->getId()] = $data;


        }

        $data = $this->dataPersistor->get('blog');
        if (!empty($data)) {
            $blogg = $this->collection->getNewEmptyItem();
            $blogg->setData($data);
            $this->loadedData[$blogg->getId()] = $blogg->getData();
            $this->dataPersistor->clear('blog');
        }
        return $this->loadedData;
    }
}