<?php

namespace Favicode\ProductFaq\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class FaqActions extends Column
{
    const FAQ_URL_PATH_EDIT = 'faq/product/edit';
    const FAQ_URL_PATH_DELETE = 'faq/product/delete';

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['faq_id'])) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->context->getUrl(
                            self::FAQ_URL_PATH_EDIT,
                            [
                                '_secure' => true,
                                'faq_id' => $item['faq_id']
                            ]
                        ),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->context->getUrl(
                            self::FAQ_URL_PATH_DELETE,
                            [
                                '_secure' => true,
                                'faq_id' => $item['faq_id']
                            ]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you want to delete a record?'),
                        ],
                        'post' => true,
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
