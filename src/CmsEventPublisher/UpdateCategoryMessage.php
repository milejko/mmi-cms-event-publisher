<?php

namespace CmsEventPublisher;

use Cms\App\CmsSkinsetConfig;
use Cms\Model\TemplateModel;
use Cms\Orm\CmsCategoryRecord;

final class UpdateCategoryMessage implements MessageInterface
{
    public function __construct(
        private CmsCategoryRecord $cmsCategoryRecord,
        private CmsSkinsetConfig $cmsSkinsetConfig,
    ) {
    }

    public function getContent(): string
    {
        return (string) json_encode(
            [
                'operation' => 'update',
                'data' => (new TemplateModel($this->cmsCategoryRecord, $this->cmsSkinsetConfig))->getTransportObject(),
            ]
        );
    }
}
