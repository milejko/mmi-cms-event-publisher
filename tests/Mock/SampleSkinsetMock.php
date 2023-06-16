<?php

namespace Tests\Mock;

use Cms\App\CmsSkinsetConfig;

class SampleSkinsetMock extends CmsSkinsetConfig
{
    public function __construct()
    {
        $this->addSkin(new SampleSkinMock());
    }
}
