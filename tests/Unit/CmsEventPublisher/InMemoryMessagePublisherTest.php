<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\DeleteCategoryMessage;
use CmsEventPublisher\InMemoryMessagePublisher;
use PHPUnit\Framework\TestCase;

class InMemoryMessagePublisherTest extends TestCase
{
    public function testIfMessageIsSent():void
    {
        $publisher = new InMemoryMessagePublisher();
        $sampleRecord = new CmsCategoryRecord();
        $sampleRecord->id = 1234;
        $sampleMessage = new DeleteCategoryMessage($sampleRecord);
        $publisher->publish($sampleMessage);
        
        self::assertEquals([$sampleMessage], $publisher->getMessages());
        $publisher->publish($sampleMessage);
        self::assertEquals([$sampleMessage, $sampleMessage], $publisher->getMessages());
    }
}
