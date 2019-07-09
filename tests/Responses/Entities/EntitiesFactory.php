<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Faker\Generator as Faker;
use InvalidArgumentException;
use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Responses\Entities\User;
use Avtocod\B2BApi\Responses\Entities\Group;
use Avtocod\B2BApi\Responses\Entities\Domain;
use Avtocod\B2BApi\Responses\Entities\Report;
use Avtocod\B2BApi\Responses\Entities\Balance;
use Avtocod\B2BApi\Responses\Entities\ReportQuery;
use Avtocod\B2BApi\Responses\Entities\ReportState;
use Avtocod\B2BApi\Responses\Entities\CleanOptions;
use Avtocod\B2BApi\Responses\Entities\ReportContent;
use Avtocod\B2BApi\Responses\Entities\ReportSourceState;

class EntitiesFactory
{
    /**
     * @var callable[]|array
     */
    private static $factories = [];

    /**
     * @param string $entity_class
     * @param array  $attributes
     * @param bool   $as_array
     *
     * @throws InvalidArgumentException
     *
     * @return object|array
     */
    public static function make(string $entity_class, array $attributes = [], bool $as_array = false)
    {
        if (\count(static::$factories) === 0) {
            static::bootUpFactories();
        }

        if (! isset(static::$factories[$entity_class])) {
            throw new InvalidArgumentException("Unknown factory [{$entity_class}]");
        }

        /** @var callable $factory */
        $factory = static::$factories[$entity_class];

        return $factory(static::getFaker(), $attributes, $as_array);
    }

    /**
     * @return void
     */
    protected static function bootUpFactories(): void
    {
        static::$factories[Domain::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'uid'         => $faker->userName,
                'comment'     => $faker->sentence,
                'name'        => $faker->sentence,
                'state'       => $faker->randomElement(['DRAFT', 'ACTIVE', 'BANNED']),
                'roles'       => $as_array
                    ? \implode(',', $faker->randomElement([[], ['CLIENT', 'USER']]))
                    : $faker->randomElement([null, ['CLIENT', 'USER']]),
                'tags'        => $as_array
                    ? \implode(',', $faker->randomElement([[], ['site', 'robot']]))
                    : $faker->randomElement([[], ['site', 'robot']]),
                'created_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisYear)
                    : $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'active_to'   => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new Domain(
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

        static::$factories[User::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
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
                'domain'      => $faker->randomElement([null, static::make(Domain::class, [], $as_array)]),
                'roles'       => $as_array
                    ? \implode(',', $faker->randomElements(
                        ['ADMIN', 'DOMAIN', 'DOMAIN_ADMIN', 'ALL_REPORTS_READ', 'ALL_REPORTS_WRITE'],
                        $faker->numberBetween(0, 5)
                    ))
                    : $faker->randomElements(
                        ['ADMIN', 'DOMAIN', 'DOMAIN_ADMIN', 'ALL_REPORTS_READ', 'ALL_REPORTS_WRITE'],
                        $faker->numberBetween(0, 5)
                    ),
                'tags'        => $as_array
                    ? \implode(',', $faker->randomElement([[], [$faker->word, $faker->word]]))
                    : $faker->randomElement([[], [$faker->word, $faker->word]]),
                'created_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisYear)
                    : $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'active_to'   => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
                'pass_hash'   => $faker->randomElement([null, $faker->md5]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new User(
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

        static::$factories[Group::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'uid'         => ($group_name = $faker->userName) . '@' . $faker->domainWord,
                'comment'     => $faker->randomElement(['', '------', $group_name, $faker->sentence]),
                'name'        => $faker->randomElement(['', $faker->sentence]),
                'users'       => $faker->randomElement([$faker->randomElements(
                    [
                        static::make(User::class, [], $as_array),
                        static::make(User::class, [], $as_array),
                        static::make(User::class, [], $as_array),
                    ],
                    $faker->numberBetween(0, 3)
                ), null]),
                'roles'       => $as_array
                    ? \implode(',', $faker->randomElements(['ADMIN', 'USER'], $faker->numberBetween(0, 2)))
                    : $faker->randomElements(['ADMIN', 'USER'], $faker->numberBetween(0, 2)),
                'tags'        => $as_array
                    ? \implode(',', $faker->randomElement([[], [$faker->word, $faker->word]]))
                    : $faker->randomElement([[], [$faker->word, $faker->word]]),
                'created_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisYear)
                    : $faker->dateTimeThisYear,
                'created_by'  => $faker->userName,
                'updated_at'  => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'updated_by'  => $faker->userName,
                'active_from' => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'active_to'   => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'id'          => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'     => $faker->randomElement([null, $faker->boolean]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new Group(
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

        static::$factories[Report::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'uid'             => ($group_name = $faker->userName) . '@' . ($domain = $faker->domainWord),
                'comment'         => $faker->randomElement(['', '------', $group_name, $faker->sentence]),
                'name'            => $faker->randomElement(['', $faker->sentence]),
                'content'         => $faker->randomElement([null, static::make(ReportContent::class, [], $as_array)]),
                'query'           => static::make(ReportQuery::class, [], $as_array),
                'vehicle_id'      => $vehicle_id = $faker->randomElement([
                    null,
                    '5TDDKRFH80S073711',
                    'Z94C241BAKR127472',
                ]),
                'report_type_uid' => $faker->word . '@' . $domain,
                'domain_uid'      => $domain,
                'tags'            => $as_array
                    ? \implode(',', $faker->randomElement([[], [$faker->word, $faker->word]]))
                    : $faker->randomElement([[], [$faker->word, $faker->word]]),
                'created_at'      => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisYear)
                    : $faker->dateTimeThisYear,
                'created_by'      => $faker->userName,
                'updated_at'      => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'updated_by'      => $faker->userName,
                'active_from'     => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'active_to'       => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
                'progress_ok'     => $faker->numberBetween(0, 15),
                'progress_wait'   => $faker->numberBetween(0, 15),
                'progress_error'  => $faker->numberBetween(0, 15),
                'state'           => static::make(ReportState::class, [], $as_array),
                'id'              => $faker->randomElement([null, $faker->randomNumber()]),
                'deleted'         => $faker->randomElement([null, $faker->boolean]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new Report(
                    $attributes['uid'],
                    $attributes['comment'],
                    $attributes['name'],
                    $attributes['content'],
                    $attributes['query'],
                    $attributes['vehicle_id'],
                    $attributes['report_type_uid'],
                    $attributes['domain_uid'],
                    $attributes['tags'],
                    $attributes['created_at'],
                    $attributes['created_by'],
                    $attributes['updated_at'],
                    $attributes['updated_by'],
                    $attributes['active_from'],
                    $attributes['active_to'],
                    $attributes['progress_ok'],
                    $attributes['progress_wait'],
                    $attributes['progress_error'],
                    $attributes['state'],
                    $attributes['id'],
                    $attributes['deleted']
                );
        };

        static::$factories[Balance::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'report_type_uid' => $faker->userName . '@' . $faker->domainWord,
                'balance_type'    => $faker->randomElement(['DAY', 'MONTH', 'TOTAL']),
                'quote_init'      => $faker->randomNumber(),
                'quote_up'        => $faker->randomNumber(),
                'quote_use'       => $faker->randomNumber(),
                'created_at'      => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisYear)
                    : $faker->dateTimeThisYear,
                'updated_at'      => $as_array
                    ? DateTimeFactory::toIso8601Zulu($faker->dateTimeThisMonth)
                    : $faker->dateTimeThisMonth,
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new Balance(
                    $attributes['report_type_uid'],
                    $attributes['balance_type'],
                    $attributes['quote_init'],
                    $attributes['quote_up'],
                    $attributes['quote_use'],
                    $attributes['created_at'],
                    $attributes['updated_at']
                );
        };

        static::$factories[ReportContent::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $data = [
                'string' => $faker->word,
                'number' => $faker->randomNumber(),
                'bool'   => $faker->boolean,
                'array'  => [
                    'string' => $faker->word,
                    'number' => $faker->randomNumber(),
                    'bool'   => $faker->boolean,
                ],
            ];

            return $as_array === true
                ? $data
                : new ReportContent($data);
        };

        static::$factories[ReportQuery::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'type' => $faker->randomElement([null, 'GRZ', 'VIN', 'BODY']),
                'body' => $faker->randomElement([null, '5TDDKRFH80S073711', 'Z94C241BAKR127472']),
                'data' => $faker->randomElement([null, ['foo' => 'bar']]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new ReportQuery(
                    $attributes['type'],
                    $attributes['body'],
                    $attributes['data']
                );
        };

        static::$factories[ReportState::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $data = $faker->randomElement([[], [static::make(ReportSourceState::class, [], $as_array)]]);

            return $as_array === true
                ? $data
                : new ReportState($data);
        };

        static::$factories[CleanOptions::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                'process_response' => $faker->randomNumber(),
                'process_request'  => $faker->randomNumber(),
                'report_log'       => $faker->randomNumber(),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new CleanOptions(
                    $attributes['process_response'],
                    $attributes['process_request'],
                    $attributes['report_log']
                );
        };

        static::$factories[ReportSourceState::class] = function (
            Faker $faker,
            array $attributes = [],
            bool $as_array = false
        ) {
            $attributes = \array_replace([
                '_id'   => $faker->randomElement(['base', 'base.ext', 'references.base', 'images.avtonomer']),
                'state' => $faker->randomElement(['ERROR', 'OK', 'PROGRESS']),
                'data'  => $faker->randomElement([null, ['foo' => 'bar']]),
            ], $attributes);

            return $as_array === true
                ? $attributes
                : new ReportSourceState(
                    $attributes['_id'],
                    $attributes['state'],
                    $attributes['data']
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
