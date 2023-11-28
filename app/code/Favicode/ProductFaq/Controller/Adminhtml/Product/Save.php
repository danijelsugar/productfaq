<?php

namespace Favicode\ProductFaq\Controller\Adminhtml\Product;

use Favicode\ProductFaq\Api\Data\FaqInterfaceFactory;
use Favicode\ProductFaq\Model\ResourceModel\Faq;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        private FaqInterfaceFactory $faqFactory,
        private Faq $faqResource,
        private StoreManagerInterface $storeManager,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (!empty($data['answer'])) {
                $data['is_answered'] = 1;
            }

            $faq = $this->faqFactory->create();

            $id = $this->getRequest()->getParam('faq_id');
            if ($id) {
                $this->faqResource->load($faq, $id);

                if (!$faq->getId()) {
                    $this->messageManager->addErrorMessage(__('This faq no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }

                if ($faq->getAnswer() !== null) {
                    $faq->setIsAnswered(1);
                }
            }

            $faq->setData($data);

            try {
                $this->faqResource->save($faq);
                $this->messageManager->addSuccessMessage(__('You saved the faq.'));
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception->getPrevious() ?: $exception);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the faq. Try again.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
