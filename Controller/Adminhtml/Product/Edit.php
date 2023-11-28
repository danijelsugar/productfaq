<?php

namespace Favicode\ProductFaq\Controller\Adminhtml\Product;

use Favicode\ProductFaq\Api\Data\FaqInterfaceFactory;
use Favicode\ProductFaq\Model\ResourceModel\Faq;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Favicode_ProductFaq::faq_all';

    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = ['edit'];

    public function __construct(
        Context $context,
        private FaqInterfaceFactory $faqFactory,
        private Faq $faqResource,
        private PageFactory $pageFactory,
    ) {
        parent::__construct($context);
    }

    public function execute(): Page|Redirect
    {
        $faqId = $this->getRequest()->getParam('faq_id');
        $faq = $this->faqFactory->create();

        $this->faqResource->load($faq, $faqId);
        if (!$faq->getId()) {
            $this->messageManager->addErrorMessage(__('This faq no longer exists.'));

            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Favicode_ProductFaq::catalog_faqs_all');
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Edit FAQ'));

        return $resultPage;
    }
}
