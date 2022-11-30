<?php

namespace CmsEventPublisher;

class InMemoryMessagePublisher implements MessagePublisherInterface
{
    private array $messages = [];

    public function publish(MessageInterface $message): void
    {
        $this->messages[] = $message->getContent();
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}
