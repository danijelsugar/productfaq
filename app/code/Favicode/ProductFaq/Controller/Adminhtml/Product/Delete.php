<?php

namespace Favicode\ProductFaq\Controller\Adminhtml\Product;

use Favicode\ProductFaq\Api\Data\FaqInterfaceFactory;
use Favicode\ProductFaq\Model\ResourceModel\Faq as FaqResource;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        private FaqInterfaceFactory $faqFactory,
        private FaqResource $faqResource,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        // check if we know what should be deleted
        $faqId = $this->getRequest()->getParam('faq_id');

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($faqId) {
            try {
                // load faq
                $faq = $this->faqFactory->create();
                $this->faqResource->load($faq, $faqId);
                // delete faq
                $this->faqResource->delete($faq);
                // show success message
                $this->messageManager->addSuccessMessage(__('The faq has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $faqId]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a faq to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
