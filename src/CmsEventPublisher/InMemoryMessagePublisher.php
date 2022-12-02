<?php

namespace CmsEventPublisher;

use Psr\Log\LoggerInterface;

class InMemoryMessagePublisher implements MessagePublisherInterface
{
    /**
     * @var array<MessageInterface>
     */
    private array $messages;

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
