<?php

namespace Favicode\ProductFaq\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class CustomerName extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if(isset($dataSource['data']['items'])) {
            foreach($dataSource['data']['items'] as &$items) {
                $firstname = $items['firstname'];
                $middlename = $items['middlename'];
                $lastname = $items['lastname'];

                $items['customer_name'] = $firstname . " " . $middlename . " " . $lastname;
            }
        }

        return $dataSource;
    }
}
