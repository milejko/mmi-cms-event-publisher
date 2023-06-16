<?php

namespace Tests\Mock;

use Cms\AbstractTemplateController;
use Cms\Api\TemplateDataTransport;
use Cms\Api\TransportInterface;

class SampleTemplateController extends AbstractTemplateController
{
    public function getTransportObject(): TransportInterface
    {
        $to = new TemplateDataTransport();
        $to->id = $this->cmsCategoryRecord->id;
        $to->path = $this->cmsCategoryRecord->uri;
        $to->template = $this->cmsCategoryRecord->template;
        return $to;
    }
}
