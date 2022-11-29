<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\DeleteCategoryMessage;
use PHPUnit\Framework\TestCase;

class DeleteMessageTest extends TestCase
{
    public function testIfMessageContainsGivenText(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleCategory->id = 134;

        $message = new DeleteCategoryMessage($sampleCategory);
        self::assertEquals('{"operation":"update","data":{"id":134}}', $message->getContent());
    }
}