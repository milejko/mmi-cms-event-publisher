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

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

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
        $channel = $this->getChannel();
        $channel->basic_publish(new AMQPMessage($message->getContent()), $this->exchange, $message->getRoute());
        $channel->close();
    }

    private function getConnection(): AMQPStreamConnection
    {
        if (null !== $this->connection) {
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
        if (null !== $this->channel) {
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
