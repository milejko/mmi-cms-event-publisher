<?php

namespace Tests\Unit\CmsEventPublisher;

use Cms\App\CmsSkinsetConfig;
use Cms\Orm\CmsCategoryRecord;
use CmsEventPublisher\UpdateCategoryMessage;
use PHPUnit\Framework\TestCase;
use Tests\Mock\SampleSkinsetMock;

class UpdateCategoryMessageTest extends TestCase
{
    public function testIfMessageContainsGivenText(): void
    {
        $sampleCategory = new CmsCategoryRecord();
        $sampleCategory->id = 1234;
        $sampleCategory->uri = '';
        $sampleCategory->template = 'application/folder';

        $sampleSkinsetConfig = new SampleSkinsetMock();

        $message = new UpdateCategoryMessage($sampleCategory, $sampleSkinsetConfig);
        self::assertEquals('{"operation":"update","data":{"id":1234,"template":"application\/folder","path":"","opensNewWindow":false,"visible":true,"attributes":[],"sections":[],"children":[],"breadcrumbs":[],"siblings":[],"_links":[]}}', $message->getContent());
        self::assertEquals('application', $message->getRoute());
    }
}
