<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\User;
use Avtocod\B2BApi\Responses\Entities\Domain;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\User
 */
class UserTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('ACTIVATION_REQUIRED', User::STATE_ACTIVATION_REQUIRED);
        $this->assertSame('ACTIVE', User::STATE_ACTIVE);
        $this->assertSame('BANNED', User::STATE_BANNED);
    }

    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(User::class, [], true);

        $user = new User(
            $uid = $attributes['uid'],
            $comment = $attributes['comment'],
            $contacts = $attributes['contacts'],
            $email = $attributes['email'],
            $login = $attributes['login'],
            $name = $attributes['name'],
            $state = $attributes['state'],
            $domain_uid = $attributes['domain_uid'],
            $domain = $this->faker->randomElement([null, EntitiesFactory::make(Domain::class)]),
            $roles = \explode(',', $attributes['roles']),
            $tags = \explode(',', $attributes['tags']),
            $created_at = DateTimeFactory::createFromIso8601Zulu($attributes['created_at']),
            $created_by = $attributes['created_by'],
            $updated_at = DateTimeFactory::createFromIso8601Zulu($attributes['updated_at']),
            $updated_by = $attributes['updated_by'],
            $active_from = DateTimeFactory::createFromIso8601Zulu($attributes['active_from']),
            $active_to = DateTimeFactory::createFromIso8601Zulu($attributes['active_to']),
            $id = $attributes['id'],
            $deleted = $attributes['deleted'],
            $pass_hash = $attributes['pass_hash']
        );

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
        $this->assertSame($updated_at, $user->getUpdatedAt());
        $this->assertSame($updated_by, $user->getUpdatedBy());
        $this->assertSame($active_from, $user->getActiveFrom());
        $this->assertSame($active_to, $user->getActiveTo());
        $this->assertSame($id, $user->getId());
        $this->assertSame($deleted, $user->isDeleted());
        $this->assertSame($pass_hash, $user->getPassHash());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(User::class, [], true);

        $user = User::fromArray([
            'uid'         => $uid = $attributes['uid'],
            'comment'     => $comment = $attributes['comment'],
            'contacts'    => $contacts = $attributes['contacts'],
            'email'       => $email = $attributes['email'],
            'login'       => $login = $attributes['login'],
            'name'        => $name = $attributes['name'],
            'state'       => $state = $attributes['state'],
            'domain_uid'  => $domain_uid = $attributes['domain_uid'],
            'roles'       => $roles = $attributes['roles'],
            'tags'        => $tags = $attributes['tags'],
            'created_at'  => $created_at = $attributes['created_at'],
            'created_by'  => $created_by = $attributes['created_by'],
            'updated_at'  => $updated_at = $attributes['updated_at'],
            'updated_by'  => $updated_by = $attributes['updated_by'],
            'active_from' => $active_from = $attributes['active_from'],
            'active_to'   => $active_to = $attributes['active_to'],

            'id'        => $id = $attributes['id'],
            'deleted'   => $deleted = $attributes['deleted'],
            'pass_hash' => $pass_hash = $attributes['pass_hash'],
            'domain'    => $domain = EntitiesFactory::make(Domain::class, [], true),
        ]);

        $this->assertSame($uid, $user->getUid());
        $this->assertSame($comment, $user->getComment());
        $this->assertSame($contacts, $user->getContacts());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($login, $user->getLogin());
        $this->assertSame($name, $user->getName());
        $this->assertSame($state, $user->getState());
        $this->assertSame($domain_uid, $user->getDomainUid());
        $this->assertSame(! empty($roles)
            ? \explode(',', $roles)
            : [], $user->getRoles());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $user->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $user->getCreatedAt());
        $this->assertSame($created_by, $user->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $user->getUpdatedAt());
        $this->assertSame($updated_by, $user->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $user->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $user->getActiveTo());

        $this->assertSame($domain['uid'], $user->getDomain()->getUid());
        $this->assertSame($id, $user->getId());
        $this->assertSame($deleted, $user->isDeleted());
        $this->assertSame($pass_hash, $user->getPassHash());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(User::class, [], true);

        $user = User::fromArray([
            'uid'         => $uid = $attributes['uid'],
            'comment'     => $comment = $attributes['comment'],
            'contacts'    => $contacts = $attributes['contacts'],
            'email'       => $email = $attributes['email'],
            'login'       => $login = $attributes['login'],
            'name'        => $name = $attributes['name'],
            'state'       => $state = $attributes['state'],
            'domain_uid'  => $domain_uid = $attributes['domain_uid'],
            'roles'       => $roles = $attributes['roles'],
            'tags'        => $tags = $attributes['tags'],
            'created_at'  => $created_at = $attributes['created_at'],
            'created_by'  => $created_by = $attributes['created_by'],
            'updated_at'  => $updated_at = $attributes['updated_at'],
            'updated_by'  => $updated_by = $attributes['updated_by'],
            'active_from' => $active_from = $attributes['active_from'],
            'active_to'   => $active_to = $attributes['active_to'],
        ]);

        $this->assertSame($uid, $user->getUid());
        $this->assertSame($comment, $user->getComment());
        $this->assertSame($contacts, $user->getContacts());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($login, $user->getLogin());
        $this->assertSame($name, $user->getName());
        $this->assertSame($state, $user->getState());
        $this->assertSame($domain_uid, $user->getDomainUid());
        $this->assertSame(! empty($roles)
            ? \explode(',', $roles)
            : [], $user->getRoles());
        $this->assertSame(! empty($tags)
            ? \explode(',', $tags)
            : [], $user->getTags());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $user->getCreatedAt());
        $this->assertSame($created_by, $user->getCreatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $user->getUpdatedAt());
        $this->assertSame($updated_by, $user->getUpdatedBy());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_from), $user->getActiveFrom());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($active_to), $user->getActiveTo());

        $this->assertNull($user->getDomain());
        $this->assertNull($user->getId());
        $this->assertNull($user->isDeleted());
        $this->assertNull($user->getPassHash());
    }
}
