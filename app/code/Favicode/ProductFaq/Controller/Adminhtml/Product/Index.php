<?php

namespace Favicode\ProductFaq\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Favicode_ProductFaq::faq_all';

    public function execute(): Page
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Favicode_ProductFaq::catalog_faqs_all');
        $resultPage->getConfig()->getTitle()->prepend(__('Customer FAQs'));
        $resultPage->getConfig()->getTitle()->prepend(__('FAQS'));
        return $resultPage;
    }
}
