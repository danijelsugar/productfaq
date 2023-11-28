<?php

namespace Favicode\ProductFaq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class Faq extends AbstractDb
{
    public function __construct(
        Context                       $context,
        private StoreManagerInterface $storeManager,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize news Resource
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('favicode_faq', 'faq_id');
    }

    public function _afterSave(\Magento\Framework\Model\AbstractModel $object): Faq
    {
        $storeId = !$object->getData('store_id') ? $this->storeManager->getStore()->getId() : $object->getData('store_id');

        $faqStoreViews = $this->getFaqStoreViews($object->getId());

        if (is_array($storeId)) {
            foreach ($storeId as $store) {
                if (!$this->getStoreRelation($object->getId(), $store)) {
                    $this->getConnection()->insert(
                        $this->getTable('favicode_faq_store'),
                        ['faq_id' => $object->getId(), 'store_id' => $store]
                    );
                }
            }

            foreach ($faqStoreViews as $faqStoreView) {
                if (!in_array($faqStoreView['store_id'], $storeId)) {
                    $this->getConnection()->delete(
                        $this->getTable('favicode_faq_store'),
                        [
                            'faq_id = ?' => $faqStoreView['faq_id'],
                            'store_id = ?' => $faqStoreView['store_id']
                        ]
                    );
                }
            }
        } else {
            if (!$this->getStoreRelation($object->getId(), $storeId)) {
                $this->getConnection()->insert(
                    $this->getTable('favicode_faq_store'),
                    ['faq_id' => $object->getId(), 'store_id' => $storeId]
                );
            }
        }

        return parent::_afterSave($object);
    }

    public function getStoreRelation(int $faqId, int|array $storeId): array
    {
        $select = $this->getConnection()->select()
            ->from($this->getTable('favicode_faq_store'))
            ->where('faq_id = ?', $faqId)
            ->where('store_id IN (?)', $storeId);

        return $this->getConnection()->fetchAll($select);
    }

    public function getFaqStoreViews(int $faqId): array
    {
        $select = $this->getConnection()->select()
            ->from($this->getTable('favicode_faq_store'))
            ->where('faq_id = ?', $faqId);

        return $this->getConnection()->fetchAll($select);
    }
}
