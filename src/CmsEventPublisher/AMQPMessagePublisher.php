<?php

namespace CmsEventPublisher;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPMessagePublisher implements MessagePublisherInterface
{
    private const EXCHANGE_TYPE = 'fanout';
    private const EXCHANGE_NAME = 'cms.content.updates';
    private const EXCHANGE_DURABLE = true;
    private const EXCHANGE_PASSIVE = false;
    private const EXCHANGE_AUTODELETE = false;

    public function __construct(
        private string $host,
        private int $port,
        private string $user,
        private string $pass
    ) {
    }

    public function publish(MessageInterface $message): void
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();

        //create the exchange if it doesn't exist already
        $channel->exchange_declare(
            self::EXCHANGE_NAME,
            self::EXCHANGE_TYPE,
            self::EXCHANGE_PASSIVE,
            self::EXCHANGE_DURABLE,
            self::EXCHANGE_AUTODELETE
        );

        $channel->basic_publish(new AMQPMessage($message->getContent()), self::EXCHANGE_NAME, $message->getRoute());
        $channel->close();
        $connection->close();
    }
}
