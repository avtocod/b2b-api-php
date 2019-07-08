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

            return new Domain(
                $attributes['uid'],
                $attributes['comment'],
                $attributes['name'],
                $attributes['state'],
                $attributes['roles'],
                $attributes['tags'],
                $attributes['created_at'],
                $attributes['created_by'],
                $attributes['updated_at'],
                $attributes['updated_by'],
                $attributes['active_from'],
                $attributes['active_to'],
                $attributes['id'],
                $attributes['deleted']
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

            return new User(
                $attributes['uid'],
                $attributes['comment'],
                $attributes['contacts'],
                $attributes['email'],
                $attributes['login'],
                $attributes['name'],
                $attributes['state'],
                $attributes['domain_uid'],
                $attributes['domain'],
                $attributes['roles'],
                $attributes['tags'],
                $attributes['created_at'],
                $attributes['created_by'],
                $attributes['updated_at'],
                $attributes['updated_by'],
                $attributes['active_from'],
                $attributes['active_to'],
                $attributes['id'],
                $attributes['deleted'],
                $attributes['pass_hash']
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

            return new Group(
                $attributes['uid'],
                $attributes['comment'],
                $attributes['name'],
                $attributes['users'],
                $attributes['roles'],
                $attributes['tags'],
                $attributes['created_at'],
                $attributes['created_by'],
                $attributes['updated_at'],
                $attributes['updated_by'],
                $attributes['active_from'],
                $attributes['active_to'],
                $attributes['id'],
                $attributes['deleted']
            );
        };
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
}
