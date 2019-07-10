<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\Domain;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\Domain<extended>
 */
class DomainTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Domain::class, [], true);

        $domain = new Domain(
            $uid = $attributes['uid'],
            $comment = $attributes['comment'],
            $name = $attributes['name'],
            $state = $attributes['state'],
            $roles = \explode(',', $attributes['roles']),
            $tags = \explode(',', $attributes['tags']),
            $created_at = DateTimeFactory::createFromIso8601Zulu($attributes['created_at']),
            $created_by = $attributes['created_by'],
            $updated_at = DateTimeFactory::createFromIso8601Zulu($attributes['updated_at']),
            $updated_by = $attributes['updated_by'],
            $active_from = DateTimeFactory::createFromIso8601Zulu($attributes['active_from']),
            $active_to = DateTimeFactory::createFromIso8601Zulu($attributes['active_to']),
            $id = $attributes['id'],
            $deleted = $attributes['deleted']
        );

        $this->assertSame($uid, $domain->getUid());
        $this->assertSame($comment, $domain->getComment());
        $this->assertSame($name, $domain->getName());
        $this->assertSame($state, $domain->getState());
        $this->assertSame($roles, $domain->getRoles());
        $this->assertSame($tags, $domain->getTags());
        $this->assertSame($created_at, $domain->getCreatedAt());
        $this->assertSame($created_by, $domain->getCreatedBy());
        $this->assertSame($updated_at, $domain->getUpdatedAt());
        $this->assertSame($updated_by, $domain->getUpdatedBy());
        $this->assertSame($active_from, $domain->getActiveFrom());
        $this->assertSame($active_to, $domain->getActiveTo());
        $this->assertSame($id, $domain->getId());
        $this->assertSame($deleted, $domain->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Domain::class, [], true);

        $domain = Domain::fromArray([
            'uid'         => $uid = $attributes['uid'],
            'comment'     => $comment = $attributes['comment'],
            'name'        => $name = $attributes['name'],
            'state'       => $state = $attributes['state'],
            'tags'        => $tags = $attributes['tags'],
            'created_at'  => $created_at = $attributes['created_at'],
            'created_by'  => $created_by = $attributes['created_by'],
            'updated_at'  => $updated_at = $attributes['updated_at'],
            'updated_by'  => $updated_by = $attributes['updated_by'],
            'active_from' => $active_from = $attributes['active_from'],
            'active_to'   => $active_to = $attributes['active_to'],

            'roles'   => $roles = $attributes['roles'],
            'id'      => $id = $attributes['id'],
            'deleted' => $deleted = $attributes['deleted'],
        ]);

        $this->assertSame($uid, $domain->getUid());
        $this->assertSame($comment, $domain->getComment());
        $this->assertSame($name, $domain->getName());
        $this->assertSame($state, $domain->getState());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $domain->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $domain->getCreatedAt());
        $this->assertSame($created_by, $domain->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $domain->getUpdatedAt());
        $this->assertSame($updated_by, $domain->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $domain->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $domain->getActiveTo());

        $this->assertSame(! empty($roles)
            ? \explode(',', $roles)
            : [], $domain->getRoles());
        $this->assertSame($id, $domain->getId());
        $this->assertSame($deleted, $domain->isDeleted());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Domain::class, [], true);

        $domain = Domain::fromArray([
            'uid'         => $uid = $attributes['uid'],
            'comment'     => $comment = $attributes['comment'],
            'name'        => $name = $attributes['name'],
            'state'       => $state = $attributes['state'],
            'tags'        => $tags = $attributes['tags'],
            'created_at'  => $created_at = $attributes['created_at'],
            'created_by'  => $created_by = $attributes['created_by'],
            'updated_at'  => $updated_at = $attributes['updated_at'],
            'updated_by'  => $updated_by = $attributes['updated_by'],
            'active_from' => $active_from = $attributes['active_from'],
            'active_to'   => $active_to = $attributes['active_to'],
        ]);

        $this->assertSame($uid, $domain->getUid());
        $this->assertSame($comment, $domain->getComment());
        $this->assertSame($name, $domain->getName());
        $this->assertSame($state, $domain->getState());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $domain->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $domain->getCreatedAt());
        $this->assertSame($created_by, $domain->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $domain->getUpdatedAt());
        $this->assertSame($updated_by, $domain->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $domain->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $domain->getActiveTo());
    }
}
