<?php

namespace CmsEventPublisher;

class InMemoryMessagePublisher implements MessagePublisherInterface
{
    /**
     * @var array<MessageInterface>
     */
    private array $messages = [];

    public function publish(MessageInterface $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * @return array<MessageInterface>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
