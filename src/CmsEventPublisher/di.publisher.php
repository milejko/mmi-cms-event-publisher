<?php

use Cms\App\CmsAppEventInterceptor;
use CmsEventPublisher\AMQPMessagePublisher;
use CmsEventPublisher\MessagePublisherInterface;
use Psr\Container\ContainerInterface;

use function DI\autowire;
use function DI\env;

return [
    'cmsEventPublisher.rabbitmq.host'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_HOST', 'localhost'),
    'cmsEventPublisher.rabbitmq.port'     => env('CMS_EVENT_PUBLISHER_RABBITMQ_PORT', '5672'),
    'cmsEventPublisher.rabbitmq.username' => env('CMS_EVENT_PUBLISHER_RABBITMQ_USERNAME', 'guest'),
    'cmsEventPublisher.rabbitmq.password' => env('CMS_EVENT_PUBLISHER_RABBITMQ_PASSWORD', 'guest'),

    //message publisher
    MessagePublisherInterface::class => function (ContainerInterface $container) {
        return new AMQPMessagePublisher(
            $container->get('cmsEventPublisher.rabbitmq.host'),
            $container->get('cmsEventPublisher.rabbitmq.port'),
            $container->get('cmsEventPublisher.rabbitmq.username'),
            $container->get('cmsEventPublisher.rabbitmq.password')
        );
    }
];