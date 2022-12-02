<?php

namespace CmsEventPublisher;

interface MessageInterface
{
    public function getContent(): string;

    public function getRoute(): string;
}
