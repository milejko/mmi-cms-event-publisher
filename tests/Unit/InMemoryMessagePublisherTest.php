<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\App\CmsSkinsetConfig;
use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\DeleteCategoryMessage;
use CmsEventPublisher\InMemoryMessagePublisher;
use PHPUnit\Framework\TestCase;

class FileMessagePublisherTest extends TestCase
{
    public function testIfMessageIsPublished(): void
    {
        $publisher = new InMemoryMessagePublisher();
        $sampleRecord = new CmsCategoryRecord();
        $sampleRecord->id = 1234;
        $sampleRecord->template = 'application/folder';

        $sampleSkinsetConfig = new CmsSkinsetConfig();

        $sampleMessage = new DeleteCategoryMessage($sampleRecord, $sampleSkinsetConfig);
        $publisher->publish($sampleMessage);

        self::assertEquals([$sampleMessage], $publisher->getMessages());

        $publisher->publish($sampleMessage);
        self::assertEquals([$sampleMessage, $sampleMessage], $publisher->getMessages());
    }
}
