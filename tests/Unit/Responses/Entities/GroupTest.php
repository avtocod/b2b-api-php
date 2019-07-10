<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\Group;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\Group<extended>
 */
class GroupTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Group::class, [], true);

        $group = new Group(
            $uid = $attributes['uid'],
            $comment = $attributes['comment'],
            $name = $attributes['name'],
            $users = $attributes['users'],
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

        $this->assertSame($uid, $group->getUid());
        $this->assertSame($comment, $group->getComment());
        $this->assertSame($name, $group->getName());
        $this->assertSame($users, $group->getUsers());
        $this->assertSame($roles, $group->getRoles());
        $this->assertSame($tags, $group->getTags());
        $this->assertSame($created_at, $group->getCreatedAt());
        $this->assertSame($created_by, $group->getCreatedBy());
        $this->assertSame($updated_at, $group->getUpdatedAt());
        $this->assertSame($updated_by, $group->getUpdatedBy());
        $this->assertSame($active_from, $group->getActiveFrom());
        $this->assertSame($active_to, $group->getActiveTo());
        $this->assertSame($id, $group->getId());
        $this->assertSame($deleted, $group->isDeleted());
    }
}
