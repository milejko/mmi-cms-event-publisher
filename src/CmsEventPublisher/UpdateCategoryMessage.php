<?php

namespace CmsEventPublisher;

final class UpdateCategoryMessage extends AbstractCategoryMessage
{
    private const OPERATION_NAME = 'update';

    public function getOperationName(): string
    {
        return self::OPERATION_NAME;
    }
}
