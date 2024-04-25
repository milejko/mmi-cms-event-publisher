<?php

namespace CmsEventPublisher;

use Cms\Api\TransportInterface;
use Cms\App\CmsSkinsetConfig;
use Cms\Model\TemplateModel;
use Cms\Orm\CmsCategoryRecord;

abstract class AbstractCategoryMessage implements MessageInterface
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
                'operation' => $this->getOperationName(),
                'record' => $this->cmsCategoryRecord->toArray(),
                'data' => $this->getCategoryData()
            ]
        );
    }

    abstract protected function getOperationName(): string;

    public function getRoute(): string
    {
        return $this->cmsCategoryRecord->getScope();
    }

    protected function getCategoryData(): TransportInterface
    {
        return (new TemplateModel($this->cmsCategoryRecord, $this->cmsSkinsetConfig))->getTransportObject();
    }
}
