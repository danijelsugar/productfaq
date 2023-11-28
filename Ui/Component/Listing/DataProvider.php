<?php

namespace Favicode\ProductFaq\Ui\Component\Listing;

use Favicode\ProductFaq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    public function getData(): array
    {
        $data = $this->getCollection()->joinCustomer()->toArray();
        return $data;
    }
}
