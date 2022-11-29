<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\App\CmsSkinConfig;
use Cms\App\CmsSkinsetConfig;
use Cms\App\CmsTemplateConfig;
use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\UpdateCategoryMessage;
use PHPUnit\Framework\TestCase;

class UpdateMessageTest extends TestCase
{
    public function testIfEmptySkinsetGivesWarningMessage(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleSkinsetConfig = new CmsSkinsetConfig;

        $message = new UpdateCategoryMessage($sampleCategory, $sampleSkinsetConfig);
        self::assertEquals('{"operation":"update","data":{"message":"Controller not found"}}', $message->getContent());
    }

}