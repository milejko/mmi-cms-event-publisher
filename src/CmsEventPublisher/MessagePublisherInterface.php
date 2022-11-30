<?php

namespace CmsEventPublisher;

interface MessagePublisherInterface
{
    public function publish(MessageInterface $message): void;
}
