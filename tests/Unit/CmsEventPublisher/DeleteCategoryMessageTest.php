<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\DeleteCategoryMessage;
use PHPUnit\Framework\TestCase;

class DeleteCategoryMessageTest extends TestCase
{
    public function testIfMessageContainsGivenText(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleCategory->id = 134;
        $sampleCategory->template = 'application/folder';

        $message = new DeleteCategoryMessage($sampleCategory);
        self::assertEquals('{"operation":"delete","data":{"id":134}}', $message->getContent());
        self::assertEquals('application', $message->getRoute());
    }
}
