<?php

namespace Favicode\ProductFaq\Api;

use Favicode\ProductFaq\Api\Data\FaqSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface FaqRepositoryInterface
{
    /**
     * Retrieve all faqs.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return FaqSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
