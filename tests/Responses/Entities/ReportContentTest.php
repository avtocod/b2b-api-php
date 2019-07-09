<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportContent;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportContent<extended>
 */
class ReportContentTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        $report_content = new ReportContent($content = ['foo' => 'bar']);

        $this->assertSame($content, $report_content->getContent());
    }

    /**
     * @return void
     */
    public function testGetByPathUsingArray(): void
    {
        $report_content = new ReportContent([
            'foo' => 'bar',
            'baz' => [
                'foo',
                'bar' => [
                    'baz',
                    'zoo',
                    123,
                ],
            ],
        ]);

        $this->assertSame('bar', $report_content->getByPath('foo'));
        $this->assertNull($report_content->getByPath('baz.foo'));
        $this->assertSame(['baz', 'zoo', 123], $report_content->getByPath('baz.bar'));
        $this->assertSame('baz', $report_content->getByPath('baz.bar.0'));
        $this->assertSame('zoo', $report_content->getByPath('baz.bar.1'));
        $this->assertSame('YAHOO', $report_content->getByPath('some.path', 'YAHOO'));
        $this->assertSame('foo', $report_content->getByPath('baz#0', null, '#'));
        $this->assertSame(123, $report_content->getByPath('baz#bar#2', null, '#'));
    }
}
