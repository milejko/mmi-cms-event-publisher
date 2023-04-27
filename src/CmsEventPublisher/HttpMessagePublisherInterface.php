<?php

namespace CmsEventPublisher;

interface HttpMessagePublisherInterface
{
    public function publish(HttpMessageInterface $message): void;
}
