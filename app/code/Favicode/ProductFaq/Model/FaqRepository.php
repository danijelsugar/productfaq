<?php

namespace Favicode\ProductFaq\Model;

use Favicode\ProductFaq\Api\Data\FaqSearchResultsInterface;
use Favicode\ProductFaq\Api\Data\FaqSearchResultsInterfaceFactory;
use Favicode\ProductFaq\Api\FaqRepositoryInterface;
use Favicode\ProductFaq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class FaqRepository implements FaqRepositoryInterface
{
    public function __construct(
        private CollectionFactory $faqCollectionFactory,
        private CollectionProcessorInterface $collectionProcessor,
        private FaqSearchResultsInterfaceFactory $searchResultsFactory
    ) {
    }

    /**
     * Retrieve all faqs.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return FaqSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Favicode\ProductFaq\Model\ResourceModel\Faq\Collection $collection */
        $collection = $this->faqCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var FaqSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
