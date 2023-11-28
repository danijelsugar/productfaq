<?php

namespace Favicode\ProductFaq\Ui\Component\Form;

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

        return $data;
    }
}
