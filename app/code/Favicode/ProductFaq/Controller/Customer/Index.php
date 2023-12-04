<?php

namespace Favicode\ProductFaq\Controller\Customer;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index implements AccountInterface, HttpGetActionInterface
{
    public function __construct(
        private ResultFactory $resultFactory,
    ) {
    }

    public function execute(): ?Page
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('faq/customer');
        }

        $resultPage->getConfig()->getTitle()->set(__('My Product Faq'));
        return $resultPage;
    }
}
