<?php

namespace Favicode\ProductFaq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface FaqSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get news list.
     *
     * @return \Favicode\ProductFaq\Api\Data\FaqInterface[]
     */
    public function getItems();

    /**
     * Set news list.
     *
     * @param \Favicode\ProductFaq\Api\Data\FaqInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
