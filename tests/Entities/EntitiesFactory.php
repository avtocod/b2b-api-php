<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Entities;

use Faker\Generator as Faker;
use InvalidArgumentException;
use Avtocod\B2BApi\Responses\Entities\User;
use Avtocod\B2BApi\Responses\Entities\Group;
use Avtocod\B2BApi\Responses\Entities\Domain;

class EntitiesFactory
{
    /**
     * @var callable[]|array
     */
    private static $factories = [];

    /**
     * @param string $entity_class
     * @param array  $attributes
     *
     * @throws InvalidArgumentException
     *
     * @return object
     */
    public static function make(string $entity_class, array $attributes = [])
    {
        if (\count(static::$factories) === 0) {
            static::bootUpFactories();
        }

        if (! isset(static::$factories[$entity_class])) {
            throw new InvalidArgumentException("Unknown factory [{$entity_class}]");
        }

        /** @var callable $factory */
        $factory = static::$factories[$entity_class];

        return $factory(static::getFaker(), $attributes);
    }

    /**
     * @return Faker
     */
    protected static function getFaker(): Faker
    {
        static $faker;

        return $faker instanceof Faker
            ? $faker
            : $faker = \Faker\Factory::create();
    }

    /**
     * @return void
     */
    protected static function bootUpFactories(): void
    {
        static::$factories[Domain::class] = function (Faker $faker, array $attributes = []): Domain {
            $attributes = \array_replace([
                'uid'         => $faker->userName,
                'comment'     => $faker->sentence,
                'name'        => $faker->sentence,
                'state'       => $faker->randomElement(['DRAFT', 'ACTIVE', 'BANNED']),
                'roles'       => $faker->randomElement([null, ['CLIENT', 'USER']]),
                'tags'        => $faker->randomElement([[], ['site', 'robot']]),
                'created_at'  => $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $faker->dateTimeThisMonth,
                'active_to'   => $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
            ], $attributes);

            /*
             * @var $uid
             * @var $comment
             * @var $name
             * @var $state
             * @var $roles
             * @var $tags
             * @var $created_at
             * @var $created_by
             * @var $updated_at
             * @var $updated_by
             * @var $active_from
             * @var $active_to
             * @var $id
             * @var $deleted
             */
            \extract($attributes);

            return new Domain(
                $uid,
                $comment,
                $name,
                $state,
                $roles,
                $tags,
                $created_at,
                $created_by,
                $updated_at,
                $updated_by,
                $active_from,
                $active_to,
                $id,
                $deleted
            );
        };

        static::$factories[User::class] = function (Faker $faker, array $attributes = []): User {
            $attributes = \array_replace([
                'uid'         => $uid = ($user_in_domain_name = $faker->userName)
                                        . '@'
                                        . ($domain_uid = $faker->domainWord),
                'comment'     => $faker->sentence,
                'contacts'    => $faker->randomElement(['------', '', $faker->streetAddress]),
                'email'       => $faker->randomElement(['------', '', $faker->email]),
                'login'       => $uid,
                'name'        => $faker->randomElement([$user_in_domain_name, $faker->sentence]),
                'state'       => $faker->randomElement(['ACTIVATION_REQUIRED', 'ACTIVE', 'BANNED']),
                'domain_uid'  => $domain_uid,
                'domain'      => $faker->randomElement([null, static::make(Domain::class)]),
                'roles'       => $faker->randomElements(
                    ['ADMIN', 'DOMAIN', 'DOMAIN_ADMIN', 'ALL_REPORTS_READ', 'ALL_REPORTS_WRITE'],
                    $faker->numberBetween(0, 5)
                ),
                'tags'        => $faker->randomElement([
                    [$faker->word, $faker->word, $faker->word],
                    $faker->words($faker->numberBetween(0, 3)),
                ]),
                'created_at'  => $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $faker->dateTimeThisMonth,
                'active_to'   => $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
                'pass_hash'   => $faker->randomElement([null, $faker->md5]),
            ], $attributes);

            /*
             * @var $uid
             * @var $comment
             * @var $contacts
             * @var $email
             * @var $login
             * @var $name
             * @var $state
             * @var $domain_uid
             * @var $domain
             * @var $roles
             * @var $tags
             * @var $created_at
             * @var $created_by
             * @var $updated_at
             * @var $updated_by
             * @var $active_from
             * @var $active_to
             * @var $id
             * @var $deleted
             * @var $pass_hash
             */
            \extract($attributes);

            return new User(
                $uid,
                $comment,
                $contacts,
                $email,
                $login,
                $name,
                $state,
                $domain_uid,
                $domain,
                $roles,
                $tags,
                $created_at,
                $created_by,
                $updated_at,
                $updated_by,
                $active_from,
                $active_to,
                $id,
                $deleted,
                $pass_hash
            );
        };

        static::$factories[Group::class] = function (Faker $faker, array $attributes = []): Group {
            $attributes = \array_replace([
                'uid'         => ($group_name = $faker->userName) . '@' . $faker->domainWord,
                'comment'     => $faker->randomElement(['', '------', $group_name, $faker->sentence]),
                'name'        => $faker->randomElement(['', $faker->sentence]),
                'users'       => $faker->randomElement([$faker->randomElements(
                    [static::make(User::class), static::make(User::class), static::make(User::class)],
                    $faker->numberBetween(0, 3)
                ), null]),
                'roles'       => $faker->randomElement([['ADMIN', 'USER'], [], null]),
                'tags'        => $faker->randomElement([[$faker->word], []]),
                'created_at'  => $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $faker->dateTimeThisMonth,
                'active_to'   => $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
            ], $attributes);

            /*
             * @var $uid
             * @var $comment
             * @var $name
             * @var $users
             * @var $roles
             * @var $tags
             * @var $created_at
             * @var $created_by
             * @var $updated_at
             * @var $updated_by
             * @var $active_from
             * @var $active_to
             * @var $id
             * @var $deleted
             */
            \extract($attributes);

            return new Group(
                $uid,
                $comment,
                $name,
                $users,
                $roles,
                $tags,
                $created_at,
                $created_by,
                $updated_at,
                $updated_by,
                $active_from,
                $active_to,
                $id,
                $deleted
            );
        };
    }
}
