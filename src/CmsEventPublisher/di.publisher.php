<?php

use CmsEventPublisher\AMQPMessagePublisher;
use CmsEventPublisher\InMemoryMessagePublisher;
use CmsEventPublisher\MessagePublisherInterface;
use Psr\Container\ContainerInterface;

use function DI\env;

return [
    'cmsEventPublisher.rabbitmq.host'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_HOST', ''),
    'cmsEventPublisher.rabbitmq.port'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_PORT', 5672),
    'cmsEventPublisher.rabbitmq.username' => env('CMS_EVENT_PUBLISHER_RABBITMQ_USERNAME', ''),
    'cmsEventPublisher.rabbitmq.password' => env('CMS_EVENT_PUBLISHER_RABBITMQ_PASSWORD', ''),

    //message publisher
    MessagePublisherInterface::class => function (ContainerInterface $container) {
        //no host info: InMemoryPublisher (test purpose)
        if (!$container->get('cmsEventPublisher.rabbitmq.host')) {
            return new InMemoryMessagePublisher();
        }
        //AMQP publisher
        return new AMQPMessagePublisher(
            $container->get('cmsEventPublisher.rabbitmq.host'),
            $container->get('cmsEventPublisher.rabbitmq.port'),
            $container->get('cmsEventPublisher.rabbitmq.username'),
            $container->get('cmsEventPublisher.rabbitmq.password')
        );
    }
];
