<?php

namespace CmsEventPublisher;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpMessagePublisher implements MessagePublisherInterface
{
    private const EXCHANGE_TYPE = 'topic';
    private const EXCHANGE_DURABLE = true;
    private const EXCHANGE_PASSIVE = false;
    private const EXCHANGE_AUTODELETE = false;

    private const CONNECTION_TIMEOUT = 2.0;
    private const READ_WRITE_TIMEOUT = 4.0;

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    private bool $connected = false;

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
        $this->lazyConnect();
        $amqpMessage = new AMQPMessage($message->getContent());
        try {
            $this->channel->basic_publish($amqpMessage, $this->exchange, $message->getRoute());
        } catch (Exception) {
            // retry as probably the connection was closed
            $this->channel->basic_publish($amqpMessage, $this->exchange, $message->getRoute());
        }
    }

    private function lazyConnect(): void
    {
        //@TODO: improve this check
        if ($this->connected && $this->connection->isConnected() && $this->channel->is_open()) {
            return;
        }
        $this->connection = $this->getConnection();
        $this->channel = $this->getChannel($this->connection);
        $this->connected = true;
    }

    private function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
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
    }

    private function getChannel(AMQPStreamConnection $connection): AMQPChannel
    {
        $channel = $connection->channel();

        //create the exchange if it doesn't exist already
        $channel->exchange_declare(
            $this->exchange,
            self::EXCHANGE_TYPE,
            self::EXCHANGE_PASSIVE,
            self::EXCHANGE_DURABLE,
            self::EXCHANGE_AUTODELETE
        );
        return $channel;
    }

    public function __destruct()
    {
        if (!$this->connected) {
            return;
        }
        $this->channel->close();
        $this->connection->close();
    }
}
