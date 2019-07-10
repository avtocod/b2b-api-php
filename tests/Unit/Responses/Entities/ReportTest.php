<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\Report;
use Avtocod\B2BApi\Responses\Entities\ReportQuery;
use Avtocod\B2BApi\Responses\Entities\ReportState;
use Avtocod\B2BApi\Responses\Entities\ReportContent;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\Report<extended>
 */
class ReportTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Report::class, [], true);

        $report = new Report(
            $uid = $attributes['uid'],
            $comment = $attributes['comment'],
            $name = $attributes['name'],
            $content = $this->faker->randomElement([null, EntitiesFactory::make(ReportContent::class)]),
            $query = EntitiesFactory::make(ReportQuery::class),
            $vehicle_id = $attributes['vehicle_id'],
            $report_type_uid = $attributes['report_type_uid'],
            $domain_uid = $attributes['domain_uid'],
            $tags = \explode(',', $attributes['tags']),
            $created_at = DateTimeFactory::createFromIso8601Zulu($attributes['created_at']),
            $created_by = $attributes['created_by'],
            $updated_at = DateTimeFactory::createFromIso8601Zulu($attributes['updated_at']),
            $updated_by = $attributes['updated_by'],
            $active_from = DateTimeFactory::createFromIso8601Zulu($attributes['active_from']),
            $active_to = DateTimeFactory::createFromIso8601Zulu($attributes['active_to']),
            $progress_ok = $attributes['progress_ok'],
            $progress_wait = $attributes['progress_wait'],
            $progress_error = $attributes['progress_error'],
            $state = EntitiesFactory::make(ReportState::class),
            $id = $attributes['id'],
            $deleted = $attributes['deleted']
        );

        $this->assertSame($uid, $report->getUid());
        $this->assertSame($comment, $report->getComment());
        $this->assertSame($name, $report->getName());
        $this->assertSame($content, $report->getContent());
        $this->assertSame($query, $report->getQuery());
        $this->assertSame($vehicle_id, $report->getVehicleId());
        $this->assertSame($report_type_uid, $report->getReportTypeUid());
        $this->assertSame($domain_uid, $report->getDomainUid());
        $this->assertSame($tags, $report->getTags());
        $this->assertSame($created_at, $report->getCreatedAt());
        $this->assertSame($created_by, $report->getCreatedBy());
        $this->assertSame($updated_at, $report->getUpdatedAt());
        $this->assertSame($updated_by, $report->getUpdatedBy());
        $this->assertSame($active_from, $report->getActiveFrom());
        $this->assertSame($active_to, $report->getActiveTo());
        $this->assertSame($progress_ok, $report->getProgressOk());
        $this->assertSame($progress_wait, $report->getProgressWait());
        $this->assertSame($progress_error, $report->getProgressError());
        $this->assertSame($state, $report->getState());
        $this->assertSame($id, $report->getId());
        $this->assertSame($deleted, $report->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Report::class, [], true);

        $report = Report::fromArray([
            'uid'             => $uid = $attributes['uid'],
            'comment'         => $comment = $attributes['comment'],
            'name'            => $name = $attributes['name'],
            'content'         => $content = EntitiesFactory::make(ReportContent::class, [], true),
            'query'           => $query = EntitiesFactory::make(ReportQuery::class, [], true),
            'vehicle_id'      => $vehicle_id = $attributes['vehicle_id'],
            'report_type_uid' => $report_type_uid = $attributes['report_type_uid'],
            'domain_uid'      => $domain_uid = $attributes['domain_uid'],
            'tags'            => $tags = $attributes['tags'],
            'created_at'      => $created_at = $attributes['created_at'],
            'created_by'      => $created_by = $attributes['created_by'],
            'updated_at'      => $updated_at = $attributes['updated_at'],
            'updated_by'      => $updated_by = $attributes['updated_by'],
            'active_from'     => $active_from = $attributes['active_from'],
            'active_to'       => $active_to = $attributes['active_to'],
            'progress_ok'     => $progress_ok = $attributes['progress_ok'],
            'progress_wait'   => $progress_wait = $attributes['progress_wait'],
            'progress_error'  => $progress_error = $attributes['progress_error'],
            'state'           => ['sources' => $state = EntitiesFactory::make(ReportState::class, [], true)],
            'id'              => $id = $attributes['id'],
            'deleted'         => $deleted = $attributes['deleted'],
        ]);

        $this->assertSame($uid, $report->getUid());
        $this->assertSame($comment, $report->getComment());
        $this->assertSame($name, $report->getName());
        $this->assertSame($content['array']['string'], $report->getContent()->getByPath('array.string'));
        $this->assertSame($query['body'], $report->getQuery()->getBody());
        $this->assertSame($vehicle_id, $report->getVehicleId());
        $this->assertSame($report_type_uid, $report->getReportTypeUid());
        $this->assertSame($domain_uid, $report->getDomainUid());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $report->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $report->getCreatedAt());
        $this->assertSame($created_by, $report->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $report->getUpdatedAt());
        $this->assertSame($updated_by, $report->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $report->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $report->getActiveTo());
        $this->assertSame($progress_ok, $report->getProgressOk());
        $this->assertSame($progress_wait, $report->getProgressWait());
        $this->assertSame($progress_error, $report->getProgressError());
        $this->assertSameSize($state, $report->getState()->getSourceStates());
        $this->assertSame($id, $report->getId());
        $this->assertSame($deleted, $report->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Report::class, [], true);

        $report = Report::fromArray([
            'uid'             => $uid = $attributes['uid'],
            'comment'         => $comment = $attributes['comment'],
            'name'            => $name = $attributes['name'],
            'query'           => $query = EntitiesFactory::make(ReportQuery::class, [], true),
            'report_type_uid' => $report_type_uid = $attributes['report_type_uid'],
            'domain_uid'      => $domain_uid = $attributes['domain_uid'],
            'tags'            => $tags = $attributes['tags'],
            'created_at'      => $created_at = $attributes['created_at'],
            'created_by'      => $created_by = $attributes['created_by'],
            'updated_at'      => $updated_at = $attributes['updated_at'],
            'updated_by'      => $updated_by = $attributes['updated_by'],
            'active_from'     => $active_from = $attributes['active_from'],
            'active_to'       => $active_to = $attributes['active_to'],
            'progress_ok'     => $progress_ok = $attributes['progress_ok'],
            'progress_wait'   => $progress_wait = $attributes['progress_wait'],
            'progress_error'  => $progress_error = $attributes['progress_error'],
            'state'           => ['sources' => $state = EntitiesFactory::make(ReportState::class, [], true)],
        ]);

        $this->assertSame($uid, $report->getUid());
        $this->assertSame($comment, $report->getComment());
        $this->assertSame($name, $report->getName());
        $this->assertSame($query['body'], $report->getQuery()->getBody());
        $this->assertSame($report_type_uid, $report->getReportTypeUid());
        $this->assertSame($domain_uid, $report->getDomainUid());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $report->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $report->getCreatedAt());
        $this->assertSame($created_by, $report->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $report->getUpdatedAt());
        $this->assertSame($updated_by, $report->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $report->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $report->getActiveTo());
        $this->assertSame($progress_ok, $report->getProgressOk());
        $this->assertSame($progress_wait, $report->getProgressWait());
        $this->assertSame($progress_error, $report->getProgressError());
        $this->assertSameSize($state, $report->getState()->getSourceStates());
    }

    /**
     * @return void
     */
    public function testIsCompleted(): void
    {
        /** @var Report $report */
        $report = EntitiesFactory::make(Report::class, [
            'progress_error' => 0,
            'progress_ok'    => 0,
            'state'          => new ReportState([EntitiesFactory::make(ReportState::class)]),
        ]);

        $this->assertFalse($report->isCompleted());

        $report = EntitiesFactory::make(Report::class, [
            'progress_error' => 1,
            'progress_ok'    => 0,
            'state'          => new ReportState([EntitiesFactory::make(ReportState::class)]),
        ]);

        $this->assertTrue($report->isCompleted());

        $report = EntitiesFactory::make(Report::class, [
            'progress_error' => 0,
            'progress_ok'    => 1,
            'state'          => new ReportState([EntitiesFactory::make(ReportState::class)]),
        ]);

        $this->assertTrue($report->isCompleted());

        $report = EntitiesFactory::make(Report::class, [
            'progress_error' => 1,
            'progress_ok'    => 1,
            'state'          => new ReportState([EntitiesFactory::make(ReportState::class)]),
        ]);

        $this->assertTrue($report->isCompleted());
    }
}
