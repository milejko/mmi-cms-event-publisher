<?php

namespace CmsEventPublisher;

use Cms\Orm\CmsCategoryRecord;

final class DeleteCategoryMessage implements MessageInterface
{
    public function __construct(private CmsCategoryRecord $cmsCategoryRecord)
    {
    }

    public function getContent(): string
    {
        return (string) json_encode([
            'operation' => 'delete',
            'data' => [
                'id' => $this->cmsCategoryRecord->id
            ]
        ]);
    }
}
