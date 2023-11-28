<?php

namespace Favicode\ProductFaq\Block\Product;

use Favicode\ProductFaq\Model\ResourceModel\Faq\Collection;
use Favicode\ProductFaq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Faq extends Template
{
    public function __construct(
        Context $context,
        private CollectionFactory $collectionFactory,
        private StoreManagerInterface $storeManager,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    public function getProductId(): ?int
    {
        $product = $this->getRequest()->getParam('id');
        return $product ?: null;
    }

    public function getFaqCollection(): Collection
    {
        $faqCollection = $this->collectionFactory->create();

        $faqCollection->addFieldToSelect(['question', 'answer'])
            ->addStoreFilter($this->storeManager->getStore()->getId())
            ->getSelect()
            ->where('is_answered = ?', 1)
            ->where('is_frequent = ?', 1)
            ->where('product_id = ?', $this->getProductId());

        return $faqCollection;

    }
}
