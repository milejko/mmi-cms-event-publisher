<?php

namespace CmsEventPublisher;

final class DeleteCategoryMessage extends AbstractCategoryMessage
{
    private const OPERATION_NAME = 'delete';

    public function getOperationName(): string
    {
        return self::OPERATION_NAME;
    }
}
