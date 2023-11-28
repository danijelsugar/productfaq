<?php

namespace Favicode\ProductFaq\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Form extends Template
{
    public function __construct(
        Context $context,
        private \Magento\Customer\Model\Session $customerSession,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    protected function _construct(): void
    {
        parent::_construct();

        $this->setTemplate('Favicode_ProductFaq::form.phtml');
    }

    public function getProductId(): ?int
    {
        $product = $this->getRequest()->getParam('id');
        return $product ?: null;
    }

    public function getAction(): string
    {
        return $this->getUrl(
            'faq/product/post',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getProductId(),
            ]
        );
    }

    public function _toHtml(): string
    {
        if (!$this->customerSession->isLoggedIn()) {
            return '';
        }
        return parent::_toHtml();
    }
}
