<?php

namespace Favicode\ProductFaq\Ui\Component\Form;

use Favicode\ProductFaq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private UrlInterface $url,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        $data = [];

        $dataObject = $this->getCollection()->joinCustomer()
            ->getFirstItem();

        if($dataObject->getId()) {
            $data[$dataObject->getId()] = $dataObject->toArray();
        }

        $adminUrls = [];

        if ($dataObject->getCustomer()) {
            $adminUrls['customer_url'] = $this->url->getUrl('customer/index/edit', ['id' => $dataObject->getCustomer()]);
        }

        if ($dataObject->getProduct()) {
            $adminUrls['product_url'] = $this->url->getUrl('catalog/product/edit', ['id' => $dataObject->getProduct()]);
        }

        $data[$dataObject->getId()] = array_merge($data[$dataObject->getId()], $adminUrls);

        return $data;
    }
}
