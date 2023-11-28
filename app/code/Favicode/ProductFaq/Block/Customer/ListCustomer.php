<?php

namespace Favicode\ProductFaq\Block\Customer;

use Favicode\ProductFaq\Model\ResourceModel\Faq\Collection;
use Favicode\ProductFaq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class ListCustomer extends Template
{
    public function __construct(
        Context $context,
        private CurrentCustomer $currentCustomer,
        private CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getFaqs(): false|Collection
    {
        if (!($customerId = $this->currentCustomer->getCustomerId())) {
            return false;
        }

        $collection = $this->collectionFactory->create();

        $collection->addFieldToSelect(['faq_id', 'product_id', 'answer', 'question', 'created_at'])
            ->getSelect()
            ->where('main_table.customer_id = ?', $customerId);

        return $collection;
    }

    /**
     * Format date in short format
     *
     * @param string $date
     * @return string
     */
    public function dateFormat(string $date): string
    {
        return $this->formatDate($date);
    }
}
