<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\App\CmsSkinsetConfig;
use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\UpdateCategoryMessage;
use PHPUnit\Framework\TestCase;

class UpdateCategoryMessageTest extends TestCase
{
    public function testIfEmptySkinsetGivesWarningMessage(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleSkinsetConfig = new CmsSkinsetConfig;

        $message = new UpdateCategoryMessage($sampleCategory, $sampleSkinsetConfig);
        self::assertEquals('{"operation":"update","data":{"message":"Controller not found"}}', $message->getContent());
    }
}
