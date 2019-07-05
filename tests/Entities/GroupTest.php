<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\User;
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
        /** @var Group $group */
        $group = EntitiesFactory::make(Group::class, [
            'uid'         => $uid = (($group_name = $this->faker->userName) . '@' . $this->faker->domainWord),
            'comment'     => $comment = $this->faker->randomElement(['', $group_name, $this->faker->sentence]),
            'name'        => $name = $this->faker->randomElement(['', $this->faker->sentence]),
            'users'       => $users = $this->faker->randomElement([$this->faker->randomElements(
                [EntitiesFactory::make(User::class), EntitiesFactory::make(User::class)],
                $this->faker->numberBetween(0, 2)
            ), null]),
            'roles'       => $roles = $this->faker->randomElement([['ADMIN', 'USER'], [], null]),
            'tags'        => $tags = $this->faker->randomElement([[$this->faker->word], []]),
            'created_at'  => $created_at = $this->faker->dateTimeThisYear,
            'created_by'  => $created_by = $this->faker->userName,
            'updated_at'  => $updated_at = $this->faker->dateTimeThisMonth,
            'updated_by'  => $updated_by = $this->faker->userName,
            'active_from' => $active_from = $this->faker->dateTimeThisMonth,
            'active_to'   => $active_to = $this->faker->dateTimeThisMonth,
            'id'          => $id = $this->faker->randomElement([null, $this->faker->randomNumber()]),
            'deleted'     => $deleted = $this->faker->randomElement([null, $this->faker->boolean]),
        ]);

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
