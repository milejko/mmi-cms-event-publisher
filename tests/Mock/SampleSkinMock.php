<?php

namespace Tests\Mock;

use Cms\App\CmsSkinConfig;
use Cms\App\CmsTemplateConfig;

class SampleSkinMock extends CmsSkinConfig
{
    public function __construct()
    {
        $this
            ->setKey('application')
            ->addTemplate((new CmsTemplateConfig())
                ->setKey('folder')
                ->setControllerClassName(SampleTemplateController::class));
    }
}
