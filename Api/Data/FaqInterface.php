<?php

namespace Favicode\ProductFaq\Api\Data;

interface FaqInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const FAQ_ID = 'faq_id';
    const PRODUCT_ID = 'product_id';
    const CUSTOMER_ID = 'customer_id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const IS_FREQUENT = 'is_frequent';
    const IS_ANSWERED = 'is_answered';
    const CREATED_AT = 'created_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set ID
     *
     * @param string $id
     * @return FaqInterface
     */
    public function setId($id): FaqInterface;

    /**
     * Get product
     *
     * @return int|null
     */
    public function getProduct(): ?int;

    /**
     * Set product
     *
     * @param string $productId
     * @return FaqInterface
     */
    public function setProduct(string $productId): FaqInterface;

    /**
     * Get customer
     *
     * @return int|null
     */
    public function getCustomer(): ?int;

    /**
     * Set customer
     *
     * @param string $customerId
     * @return FaqInterface
     */
    public function setCustomer(string $customerId): FaqInterface;

    /**
     * Get question
     *
     * @return string|null
     */
    public function getQuestion(): ?string;

    /**
     * Set question
     *
     * @param string $question
     * @return FaqInterface
     */
    public function setQuestion(string $question): FaqInterface;

    /**
     * Get answer
     *
     * @return string|null
     */
    public function getAnswer(): ?string;

    /**
     * Set product
     *
     * @param string $answer
     * @return FaqInterface
     */
    public function setAnswer(string $answer): FaqInterface;

    /**
     * Get product
     *
     * @return bool|null
     */
    public function getIsFrequent(): ?bool;

    /**
     * Set product
     *
     * @param bool $isFrequent
     * @return FaqInterface
     */
    public function setIsFrequent(bool $isFrequent): FaqInterface;

    /**
     * Get product
     *
     * @return bool|null
     */
    public function getIsAnswered(): ?bool;

    /**
     * Set product
     *
     * @param bool $isAnswered
     * @return FaqInterface
     */
    public function setIsAnswered(bool $isAnswered): FaqInterface;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return FaqInterface
     */
    public function setCreatedAt(string $createdAt): FaqInterface;
}
