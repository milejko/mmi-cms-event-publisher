<?php

use CmsEventPublisher\AMQPMessagePublisher;
use CmsEventPublisher\InMemoryMessagePublisher;
use CmsEventPublisher\MessagePublisherInterface;
use CmsEventPublisher\HttpMessagePublisher;
use CmsEventPublisher\HttpMessagePublisherInterface;
use Psr\Container\ContainerInterface;

use function DI\env;

return [
    'cmsEventPublisher.rabbitmq.enabled'  => env('CMS_EVENT_PUBLISHER_RABBITMQ_ENABLED', false),
    'cmsEventPublisher.rabbitmq.host'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_HOST', 'localhost'),
    'cmsEventPublisher.rabbitmq.port'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_PORT', 5672),
    'cmsEventPublisher.rabbitmq.vhost'    => env('CMS_EVENT_PUBLISHER_RABBITMQ_VHOST', 'cms'),
    'cmsEventPublisher.rabbitmq.username' => env('CMS_EVENT_PUBLISHER_RABBITMQ_USERNAME', ''),
    'cmsEventPublisher.rabbitmq.password' => env('CMS_EVENT_PUBLISHER_RABBITMQ_PASSWORD', ''),
    'cmsEventPublisher.http'              => env('CMS_EVENT_PUBLISHER_HTTP', false),

    //message publisher
    MessagePublisherInterface::class => function (ContainerInterface $container) {
        //rabbit not enabled (using file publisher)
        if (!$container->get('cmsEventPublisher.rabbitmq.enabled')) {
            return new InMemoryMessagePublisher();
        }
        //AMQP publisher
        return new AMQPMessagePublisher(
            $container->get('cmsEventPublisher.rabbitmq.host'),
            $container->get('cmsEventPublisher.rabbitmq.port'),
            $container->get('cmsEventPublisher.rabbitmq.username'),
            $container->get('cmsEventPublisher.rabbitmq.password'),
            $container->get('cmsEventPublisher.rabbitmq.vhost'),
        );
    },

    HttpMessagePublisherInterface::class => function (ContainerInterface $container) {
        return new HttpMessagePublisher((bool)$container->get('cmsEventPublisher.http'));
    }
];
