<?php

namespace CmsEventPublisher;

class HttpMessagePublisher implements HttpMessagePublisherInterface
{
    public function __construct(private bool $isActive)
    {
    }

    public function publish(HttpMessageInterface $message): void
    {
        if (!$this->isActive) {
            return;
        }

        $message->request();
    }
}
