<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\DeleteCategoryMessage;
use PHPUnit\Framework\TestCase;
use Tests\Mock\SampleSkinsetMock;

class DeleteCategoryMessageTest extends TestCase
{
    public function testIfMessageContainsGivenText(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleCategory->id = 134;
        $sampleCategory->uri = 'test';
        $sampleCategory->template = 'application/folder';

        $sampleSkinsetConfig = new SampleSkinsetMock();

        $message = new DeleteCategoryMessage($sampleCategory, $sampleSkinsetConfig);
        self::assertEquals('{"operation":"delete","data":{"id":134,"template":"application\/folder","path":"test","opensNewWindow":false,"visible":true,"attributes":[],"sections":[],"children":[],"breadcrumbs":[],"siblings":[],"_links":[]}}', $message->getContent());
        self::assertEquals('application', $message->getRoute());
    }
}
