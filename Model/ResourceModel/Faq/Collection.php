<?php

namespace Favicode\ProductFaq\Model\ResourceModel\Faq;

use Favicode\ProductFaq\Model\Faq;
use Favicode\ProductFaq\Model\ResourceModel\Faq as FaqResource;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        private CollectionFactory $productCollection,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Initialize news Collection
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            Faq::class,
            FaqResource::class
        );
    }

    /**
     * Add store filter
     *
     * @param int|int[] $storeId
     * @return $this
     */
    public function addStoreFilter(array|int $storeId): Collection
    {
        $inCond = $this->getConnection()->prepareSqlCondition('store.store_id', ['in' => $storeId]);
        $this->getSelect()->join(
            ['store' => 'favicode_faq_store'],
            'main_table.faq_id=store.faq_id',
            ['store_id']
        );
        $this->getSelect()->where($inCond);
        return $this;
    }

    /**
     * Example how to join
     */
    public function joinProductName(): Collection
    {
        $this->getSelect()
        ->join(['product_varchar' => 'catalog_product_entity_varchar'], 'product.entity_id=product_varchar.entity_id');
        return $this;
    }

    public function joinCustomer(): Collection
    {
        $this->getSelect()->join(
            ['customer' => 'customer_entity'],
            'main_table.customer_id=customer.entity_id',
            ['firstname', 'middlename', 'lastname']
        );
        return $this;
    }

    protected function _afterLoad(): Collection
    {
        if ($this->getItems()) {
            $productIds = $this->getColumnValues('product_id');

            $productCollection = $this->productCollection->create();

            $productCollection->addFieldToFilter('entity_id', $productIds)
                ->addAttributeToSelect(['name'])
                ->addUrlRewrite()
                ->getItems();

            foreach($this->getItems() as $faq) {

                $select = $this->getResource()->getConnection()
                    ->select()
                    ->from($this->getTable('favicode_faq_store'))
                    ->where('faq_id = ?', $faq->getId());

                $faqStores = $this->getConnection()->fetchall($select);

                $faq->setData('store_id', array_map(function ($faqStore) {
                    return $faqStore['store_id'];
                }, $faqStores));

                foreach ($productCollection as $item) {
                    if ($item->getData('entity_id') == $faq->getProduct()) {
                        $faq->setData('product_name', $item->getData('name'));
                        $faq->setData('product_url', $item->getData('request_path'));
                    }
                }
            }
        }

        return parent::_afterLoad();
    }
}
