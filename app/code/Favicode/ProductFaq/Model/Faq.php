<?php

namespace Favicode\ProductFaq\Model;

use Favicode\ProductFaq\Api\Data\FaqInterface;
use Favicode\ProductFaq\Model\ResourceModel\Faq as FaqResource;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Validator\NotEmpty;
use Magento\Framework\Validator\ValidateException;
use Magento\Framework\Validator\ValidatorChain;

class Faq extends AbstractModel implements FaqInterface
{
    /**
     * Initialize news Model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(FaqResource::class);
    }

    public function getId(): ?int
    {
        return $this->getData(self::FAQ_ID);
    }

    public function setId($id): FaqInterface
    {
        return $this->setData(self::FAQ_ID, $id);
    }

    public function getProduct(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    public function setProduct(string $productId): FaqInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    public function getCustomer(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomer(string $customerId): FaqInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getQuestion(): ?string
    {
        return $this->getData(self::QUESTION);
    }

    public function setQuestion(string $question): FaqInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    public function getAnswer(): ?string
    {
        return $this->getData(self::ANSWER);
    }

    public function setAnswer(string $answer): FaqInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    public function getIsFrequent(): ?bool
    {
        return $this->getData(self::IS_FREQUENT);
    }

    public function setIsFrequent(bool $isFrequent): FaqInterface
    {
        return $this->setData(self::IS_FREQUENT, $isFrequent);
    }

    public function getIsAnswered(): ?bool
    {
        return $this->getData(self::IS_ANSWERED);
    }

    public function setIsAnswered(bool $isAnswered): FaqInterface
    {
        return $this->setData(self::IS_ANSWERED, $isAnswered);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): FaqInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Validate review summary fields
     *
     * @return bool|string[]
     * @throws ValidateException
     */
    public function validate(): array|bool
    {
        $errors = [];

        if (!ValidatorChain::is($this->getQuestion(), NotEmpty::class)) {
            $errors[] = __('Please enter a question.');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }
}
