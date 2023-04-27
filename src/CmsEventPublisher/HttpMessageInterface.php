<?php

namespace CmsEventPublisher;

interface HttpMessageInterface
{
    public function getUrl(): string;

    public function request(): void;
}
