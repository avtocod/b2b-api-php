<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportType;
use Avtocod\B2BApi\Responses\Entities\CleanOptions;
use Avtocod\B2BApi\Responses\Entities\ReportTypeContent;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportType
 */
class ReportTypeTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('DRAFT', ReportType::STATE_DRAFT);
        $this->assertSame('PUBLISHED', ReportType::STATE_PUBLISHED);
        $this->assertSame('OBSOLETE', ReportType::STATE_OBSOLETE);
        $this->assertSame('TRANSACTIONAL', ReportType::REPORT_MAKE_MODE_TRANSACTIONAL);
        $this->assertSame('FAST_NON_TRANSACTIONAL', ReportType::REPORT_MAKE_MODE_FAST_NON_TRANSACTIONAL);
        $this->assertSame('FAST_NON_BALANCE', ReportType::REPORT_MAKE_MODE_FAST_NON_BALANCE);
    }

    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportType::class, [], true);

        $report_type = new ReportType(
            $uid = $attributes['uid'],
            $comment = $attributes['comment'],
            $name = $attributes['name'],
            $state = $attributes['state'],
            $tags = \explode(',', $attributes['tags']),
            $max_age = $attributes['max_age'],
            $domain_uid = $attributes['domain_uid'],
            $content = EntitiesFactory::make(ReportTypeContent::class),
            $day_quote = $attributes['day_quote'],
            $month_quote = $attributes['month_quote'],
            $total_quote = $attributes['total_quote'],
            $min_priority = $attributes['min_priority'],
            $max_priority = $attributes['max_priority'],
            $period_priority = $attributes['period_priority'],
            $max_request = $attributes['max_request'],
            $created_at = DateTimeFactory::createFromIso8601Zulu($attributes['created_at']),
            $created_by = $attributes['created_by'],
            $updated_at = DateTimeFactory::createFromIso8601Zulu($attributes['updated_at']),
            $updated_by = $attributes['updated_by'],
            $active_from = DateTimeFactory::createFromIso8601Zulu($attributes['active_from']),
            $active_to = DateTimeFactory::createFromIso8601Zulu($attributes['active_to']),
            $clean_options = EntitiesFactory::make(CleanOptions::class),
            $report_make_mode = $attributes['report_make_mode'],
            $id = $attributes['id'],
            $deleted = $attributes['deleted']
        );

        $this->assertSame($uid, $report_type->getUid());
        $this->assertSame($comment, $report_type->getComment());
        $this->assertSame($name, $report_type->getName());
        $this->assertSame($state, $report_type->getState());
        $this->assertSame($tags, $report_type->getTags());
        $this->assertSame($max_age, $report_type->getMaxAge());
        $this->assertSame($domain_uid, $report_type->getDomainUid());
        $this->assertSame($content, $report_type->getContent());
        $this->assertSame($day_quote, $report_type->getDayQuote());
        $this->assertSame($month_quote, $report_type->getMonthQuote());
        $this->assertSame($total_quote, $report_type->getTotalQuote());
        $this->assertSame($min_priority, $report_type->getMinPriority());
        $this->assertSame($max_priority, $report_type->getMaxPriority());
        $this->assertSame($period_priority, $report_type->getPeriodPriority());
        $this->assertSame($max_request, $report_type->getMaxRequest());
        $this->assertSame($created_at, $report_type->getCreatedAt());
        $this->assertSame($created_by, $report_type->getCreatedBy());
        $this->assertSame($updated_at, $report_type->getUpdatedAt());
        $this->assertSame($updated_by, $report_type->getUpdatedBy());
        $this->assertSame($active_from, $report_type->getActiveFrom());
        $this->assertSame($active_to, $report_type->getActiveTo());
        $this->assertSame($clean_options, $report_type->getCleanOptions());
        $this->assertSame($report_make_mode, $report_type->getReportMakeMode());
        $this->assertSame($id, $report_type->getId());
        $this->assertSame($deleted, $report_type->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportType::class, [], true);

        $report_type = ReportType::fromArray([
            'uid'              => $uid = $attributes['uid'],
            'comment'          => $comment = $attributes['comment'],
            'name'             => $name = $attributes['name'],
            'state'            => $state = $attributes['state'],
            'tags'             => $tags = $attributes['tags'],
            'max_age'          => $max_age = $attributes['max_age'],
            'domain_uid'       => $domain_uid = $attributes['domain_uid'],
            'content'          => $content = EntitiesFactory::make(ReportTypeContent::class, [], true),
            'day_quote'        => $day_quote = $attributes['day_quote'],
            'month_quote'      => $month_quote = $attributes['month_quote'],
            'total_quote'      => $total_quote = $attributes['total_quote'],
            'min_priority'     => $min_priority = $attributes['min_priority'],
            'max_priority'     => $max_priority = $attributes['max_priority'],
            'period_priority'  => $period_priority = $attributes['period_priority'],
            'max_request'      => $max_request = $attributes['max_request'],
            'created_at'       => $created_at = $attributes['created_at'],
            'created_by'       => $created_by = $attributes['created_by'],
            'updated_at'       => $updated_at = $attributes['updated_at'],
            'updated_by'       => $updated_by = $attributes['updated_by'],
            'active_from'      => $active_from = $attributes['active_from'],
            'active_to'        => $active_to = $attributes['active_to'],
            'clean_options'    => $clean_options = EntitiesFactory::make(CleanOptions::class, [
                'Process_Response' => $clean_process_response = 123,
            ], true),
            'report_make_mode' => $report_make_mode = $attributes['report_make_mode'],
            'id'               => $id = $attributes['id'],
            'deleted'          => $deleted = $attributes['deleted'],
        ]);

        $this->assertSame($uid, $report_type->getUid());
        $this->assertSame($comment, $report_type->getComment());
        $this->assertSame($name, $report_type->getName());
        $this->assertSame($state, $report_type->getState());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $report_type->getTags());
        $this->assertSame($max_age, $report_type->getMaxAge());
        $this->assertSame($domain_uid, $report_type->getDomainUid());
        $this->assertSame($content['sources'], $report_type->getContent()->getSources());
        $this->assertSame($content['fields'], $report_type->getContent()->getFields());
        $this->assertSame($day_quote, $report_type->getDayQuote());
        $this->assertSame($month_quote, $report_type->getMonthQuote());
        $this->assertSame($total_quote, $report_type->getTotalQuote());
        $this->assertSame($min_priority, $report_type->getMinPriority());
        $this->assertSame($max_priority, $report_type->getMaxPriority());
        $this->assertSame($period_priority, $report_type->getPeriodPriority());
        $this->assertSame($max_request, $report_type->getMaxRequest());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $report_type->getCreatedAt());
        $this->assertSame($created_by, $report_type->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $report_type->getUpdatedAt());
        $this->assertSame($updated_by, $report_type->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $report_type->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $report_type->getActiveTo());
        $this->assertSame($clean_process_response, $report_type->getCleanOptions()->getProcessResponse());
        $this->assertSame($report_make_mode, $report_type->getReportMakeMode());
        $this->assertSame($id, $report_type->getId());
        $this->assertSame($deleted, $report_type->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportType::class, [], true);

        $report_type = ReportType::fromArray([
            'uid'             => $uid = $attributes['uid'],
            'comment'         => $comment = $attributes['comment'],
            'name'            => $name = $attributes['name'],
            'state'           => $state = $attributes['state'],
            'tags'            => $tags = $attributes['tags'],
            'max_age'         => $max_age = $attributes['max_age'],
            'domain_uid'      => $domain_uid = $attributes['domain_uid'],
            'day_quote'       => $day_quote = $attributes['day_quote'],
            'month_quote'     => $month_quote = $attributes['month_quote'],
            'total_quote'     => $total_quote = $attributes['total_quote'],
            'min_priority'    => $min_priority = $attributes['min_priority'],
            'max_priority'    => $max_priority = $attributes['max_priority'],
            'period_priority' => $period_priority = $attributes['period_priority'],
            'max_request'     => $max_request = $attributes['max_request'],
            'created_at'      => $created_at = $attributes['created_at'],
            'created_by'      => $created_by = $attributes['created_by'],
            'updated_at'      => $updated_at = $attributes['updated_at'],
            'updated_by'      => $updated_by = $attributes['updated_by'],
            'active_from'     => $active_from = $attributes['active_from'],
            'active_to'       => $active_to = $attributes['active_to'],
        ]);

        $this->assertSame($uid, $report_type->getUid());
        $this->assertSame($comment, $report_type->getComment());
        $this->assertSame($name, $report_type->getName());
        $this->assertSame($state, $report_type->getState());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $report_type->getTags());
        $this->assertSame($max_age, $report_type->getMaxAge());
        $this->assertSame($domain_uid, $report_type->getDomainUid());
        $this->assertSame($day_quote, $report_type->getDayQuote());
        $this->assertSame($month_quote, $report_type->getMonthQuote());
        $this->assertSame($total_quote, $report_type->getTotalQuote());
        $this->assertSame($min_priority, $report_type->getMinPriority());
        $this->assertSame($max_priority, $report_type->getMaxPriority());
        $this->assertSame($period_priority, $report_type->getPeriodPriority());
        $this->assertSame($max_request, $report_type->getMaxRequest());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $report_type->getCreatedAt());
        $this->assertSame($created_by, $report_type->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $report_type->getUpdatedAt());
        $this->assertSame($updated_by, $report_type->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $report_type->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $report_type->getActiveTo());
    }
}
