<?php

namespace Request;

use newrelic\DistributedTracePayload;

class AddReviewRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getRating(): int
    {
        return $this->data['rating'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }
}