<?php

namespace CmsEventPublisher;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpMessagePublisher implements MessagePublisherInterface
{
    private const EXCHANGE_TYPE = 'topic';
    private const EXCHANGE_DURABLE = true;
    private const EXCHANGE_PASSIVE = false;
    private const EXCHANGE_AUTODELETE = false;

    private const CONNECTION_TIMEOUT = 1.0;
    private const READ_WRITE_TIMEOUT = 2.0;

    private AMQPChannel $channel;
    private AMQPStreamConnection $connection;

    public function __construct(
        private string $host,
        private int $port,
        private string $user,
        private string $password,
        private string $vhost,
        private string $exchange
    ) {
    }

    public function publish(MessageInterface $message): void
    {
        $this->getChannel()->basic_publish(new AMQPMessage($message->getContent()), $this->exchange, $message->getRoute());
    }

    private function getConnection(): AMQPStreamConnection
    {
        if ($this->connection instanceof AMQPStreamConnection) {
            return $this->connection;
        }
        $connection = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->password,
            $this->vhost,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            self::CONNECTION_TIMEOUT,
            self::READ_WRITE_TIMEOUT,
        );
        return $this->connection = $connection;
    }

    private function getChannel(): AMQPChannel
    {
        if ($this->channel instanceof AMQPChannel) {
            return $this->channel;
        }
        $channel = $this->getConnection()->channel();

        //create the exchange if it doesn't exist already
        $channel->exchange_declare(
            $this->exchange,
            self::EXCHANGE_TYPE,
            self::EXCHANGE_PASSIVE,
            self::EXCHANGE_DURABLE,
            self::EXCHANGE_AUTODELETE
        );
        return $this->channel = $channel;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
