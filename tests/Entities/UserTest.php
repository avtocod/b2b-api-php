<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\User;
use Avtocod\B2BApi\Responses\Entities\Domain;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\User<extended>
 */
class UserTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testGetters(): void
    {
        /** @var User $user */
        $user = EntitiesFactory::make(User::class, [
            'uid'         => $uid = $this->faker->userName . '@' . $this->faker->domainWord,
            'comment'     => $comment = $this->faker->sentence,
            'contacts'    => $contacts = $this->faker->randomElement(['------', '', $this->faker->streetAddress]),
            'email'       => $email = $this->faker->randomElement(['------', '', $this->faker->email]),
            'login'       => $login = $this->faker->userName,
            'name'        => $name = $this->faker->randomElement([$this->faker->userName, $this->faker->sentence]),
            'state'       => $state = $this->faker->randomElement(['ACTIVATION_REQUIRED', 'ACTIVE', 'BANNED']),
            'domain_uid'  => $domain_uid = $this->faker->domainWord,
            'domain'      => $domain = $this->faker->randomElement([null, EntitiesFactory::make(Domain::class)]),
            'roles'       => $roles = $this->faker->randomElements(
                ['ADMIN', 'DOMAIN', 'DOMAIN_ADMIN', 'ALL_REPORTS_READ', 'ALL_REPORTS_WRITE'],
                $this->faker->numberBetween(1, 5)
            ),
            'tags'        => $tags = $this->faker->randomElement([
                [],
                $this->faker->words($this->faker->numberBetween(0, 3)),
            ]),
            'created_at'  => $created_at = $this->faker->dateTimeThisYear,
            'created_by'  => $created_by = $this->faker->userName,
            'updated_at'  => $updated_at = $this->faker->dateTimeThisMonth,
            'updated_by'  => $updated_by = $this->faker->userName,
            'active_from' => $active_from = $this->faker->dateTimeThisMonth,
            'active_to'   => $active_to = $this->faker->dateTimeThisMonth,
            'id'          => $id = $this->faker->randomElement([null, $this->faker->randomNumber()]),
            'deleted'     => $deleted = $this->faker->randomElement([null, $this->faker->boolean]),
            'pass_hash'   => $pass_hash = $this->faker->randomElement([null, $this->faker->md5]),
        ]);

        $this->assertSame($uid, $user->getUid());
        $this->assertSame($comment, $user->getComment());
        $this->assertSame($contacts, $user->getContacts());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($login, $user->getLogin());
        $this->assertSame($name, $user->getName());
        $this->assertSame($state, $user->getState());
        $this->assertSame($domain_uid, $user->getDomainUid());
        $this->assertSame($domain, $user->getDomain());
        $this->assertSame($roles, $user->getRoles());
        $this->assertSame($tags, $user->getTags());
        $this->assertSame($created_at, $user->getCreatedAt());
        $this->assertSame($created_by, $user->getCreatedBy());
        $this->assertSame($active_from, $user->getActiveFrom());
        $this->assertSame($active_to, $user->getActiveTo());
        $this->assertSame($id, $user->getId());
        $this->assertSame($deleted, $user->isDeleted());
        $this->assertSame($pass_hash, $user->getPassHash());
    }
}
