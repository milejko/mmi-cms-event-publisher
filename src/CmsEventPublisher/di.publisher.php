<?php

use CmsEventPublisher\AmqpMessagePublisher;
use CmsEventPublisher\InMemoryMessagePublisher;
use CmsEventPublisher\MessagePublisherInterface;
use Psr\Container\ContainerInterface;

use function DI\env;

return [
    'cms.publisher.queue.enabled'   => env('CMS_PUBLISHER_QUEUE_ENABLED', false),
    'cms.publisher.queue.host'      => env('CMS_PUBLISHER_QUEUE_HOST', 'localhost'),
    'cms.publisher.queue.port'      => env('CMS_PUBLISHER_QUEUE_PORT', 5672),
    'cms.publisher.queue.vhost'     => env('CMS_PUBLISHER_QUEUE_VHOST', 'cms'),
    'cms.publisher.queue.username'  => env('CMS_PUBLISHER_QUEUE_USERNAME', ''),
    'cms.publisher.queue.password'  => env('CMS_PUBLISHER_QUEUE_PASSWORD', ''),
    'cms.publisher.queue.exchange'  => env('CMS_PUBLISHER_QUEUE_EXCHANGE', 'cms.content.updates'),

    //message publisher
    MessagePublisherInterface::class => function (ContainerInterface $container) {
        //rabbit not enabled (using file publisher)
        if (!$container->get('cms.publisher.queue.enabled')) {
            return new InMemoryMessagePublisher();
        }
        //AMQP publisher
        return new AmqpMessagePublisher(
            $container->get('cms.publisher.queue.host'),
            $container->get('cms.publisher.queue.port'),
            $container->get('cms.publisher.queue.username'),
            $container->get('cms.publisher.queue.password'),
            $container->get('cms.publisher.queue.vhost'),
            $container->get('cms.publisher.queue.exchange')
        );
    }
];
