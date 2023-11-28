<?php

namespace Favicode\ProductFaq\Controller\Product;

use Favicode\ProductFaq\Api\Data\FaqInterfaceFactory;
use Favicode\ProductFaq\Model\ResourceModel\Faq as FaqResource;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

class Post implements HttpPostActionInterface
{
    public function __construct(
        private ResultFactory $resultFactory,
        private Validator $formKeyValidator,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private ProductRepositoryInterface $productRepository,
        private StoreManagerInterface $storeManager,
        private FaqInterfaceFactory $faqFactory,
        private FaqResource $faqResource,
        private ManagerInterface $messageManager,
        private Session $customer,
    ) {
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->request)) {
            return $resultRedirect->setUrl($this->redirect->getRefererUrl());
        }
        $data = $this->request->getPostValue();

        $customerId = $this->customer->getCustomerId();

        $productId = (int) $this->request->getParam('id');
        $product = $this->initProduct($productId);
        if ($product && !empty($data)) {
            $faq = $this->faqFactory->create()->setData($data);
            $faq->setProduct($productId);
            $faq->setCustomer($customerId);

            $validate = $faq->validate();
            if ($validate === true) {
                try {
                    $this->faqResource->save($faq);
                    $this->messageManager->addSuccessMessage(__('You submitted your question for moderation.'));
                } catch (\Exception $exception) {
                    $this->messageManager->addErrorMessage(__('We can\'t post your question right now.'));
                }
            } else {
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $this->messageManager->addErrorMessage($errorMessage);
                    }
                } else {
                    $this->messageManager->addErrorMessage(__('We can\'t post your question right now.'));
                }
            }

        }

        return $resultRedirect->setUrl($this->redirect->getRefererUrl());
    }

    /**
     * @param int $productId
     * @return bool|ProductInterface
     */
    public function initProduct(int $productId): bool|ProductInterface
    {
        if (!$productId) {
            return false;
        }

        try {
            $product = $this->productRepository->getById($productId);

            if (!in_array($this->storeManager->getStore()->getWebsiteId(), $product->getWebsiteIds())) {
                throw new NoSuchEntityException();
            }

            if (!$product->isVisibleInCatalog() || !$product->isVisibleInSiteVisibility()) {
                throw new NoSuchEntityException();
            }
        } catch (NoSuchEntityException $noSuchEntityException) {
            return false;
        }

        return $product;
    }
}
