<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTimeImmutable;
use Avtocod\B2BApi\DateTimeFactory;

class Domain implements CanCreateSelfFromArrayInterface
{
    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var array<string>|null
     */
    protected $roles;

    /**
     * @var array<string>
     */
    protected $tags;

    /**
     * @var DateTimeImmutable
     */
    protected $created_at;

    /**
     * @var string
     */
    protected $created_by;

    /**
     * @var DateTimeImmutable
     */
    protected $updated_at;

    /**
     * @var string
     */
    protected $updated_by;

    /**
     * @var DateTimeImmutable
     */
    protected $active_from;

    /**
     * @var DateTimeImmutable
     */
    protected $active_to;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var bool|null
     */
    protected $deleted;

    /**
     * Create a new domain instance.
     *
     * @param string             $uid         Unique domain ID (e.g. `test`)
     * @param string             $comment     Domain comment
     * @param string             $name        Human-readable domain name
     * @param string             $state       Domain state (e.g.: `DRAFT`, `ACTIVE`, `BANNED`)
     * @param array<string>|null $roles       Domain roles (optional)
     * @param array<string>      $tags        Additional domain tags
     * @param DateTimeImmutable  $created_at  Domain created at
     * @param string             $created_by  Domain creator
     * @param DateTimeImmutable  $updated_at  Last changes was made at
     * @param string             $updated_by  Last changes was made by
     * @param DateTimeImmutable  $active_from Active from
     * @param DateTimeImmutable  $active_to   Active to
     * @param int|null           $id          Internal database identifier (optional, only for administrators)
     * @param bool|null          $deleted     Is deleted flag (optional, only for administrators)
     */
    public function __construct(string $uid,
                                string $comment,
                                string $name,
                                string $state,
                                ?array $roles,
                                array $tags,
                                DateTimeImmutable $created_at,
                                string $created_by,
                                DateTimeImmutable $updated_at,
                                string $updated_by,
                                DateTimeImmutable $active_from,
                                DateTimeImmutable $active_to,
                                ?int $id,
                                ?bool $deleted)
    {
        $this->uid         = $uid;
        $this->comment     = $comment;
        $this->name        = $name;
        $this->state       = $state;
        $this->roles       = $roles;
        $this->tags        = $tags;
        $this->created_at  = $created_at;
        $this->created_by  = $created_by;
        $this->updated_at  = $updated_at;
        $this->updated_by  = $updated_by;
        $this->active_from = $active_from;
        $this->active_to   = $active_to;
        $this->id          = $id;
        $this->deleted     = $deleted;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['uid'],
            $data['comment'],
            $data['name'],
            $data['state'],
            isset($data['roles'])
                ? \array_filter(\explode(',', $data['roles']))
                : null,
            \array_filter(\explode(',', $data['tags'])),
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['created_at'])),
            $data['created_by'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['updated_at'])),
            $data['updated_by'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['active_from'])),
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['active_to'])),
            $data['id'] ?? null,
            $data['deleted'] ?? null
        );
    }

    /**
     * Get unique domain ID.
     *
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Get domain comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get human-readable domain name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get domain state.
     *
     * @return string E.g.: `DRAFT`, `ACTIVE`, `BANNED`
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get domain roles.
     *
     * @return array<string>|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * Get additional domain tags.
     *
     * @return array<string>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Get created at date/time.
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * Get domain creator.
     *
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->created_by;
    }

    /**
     * Get last changes date/time.
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updated_at;
    }

    /**
     * Get last changes author.
     *
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return $this->updated_by;
    }

    /**
     * Get active from date/time.
     *
     * @return DateTimeImmutable
     */
    public function getActiveFrom(): DateTimeImmutable
    {
        return $this->active_from;
    }

    /**
     * Get active to date/time.
     *
     * @return DateTimeImmutable
     */
    public function getActiveTo(): DateTimeImmutable
    {
        return $this->active_to;
    }

    /**
     * Get internal database identifier (only for administrators).
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get deleted flag (only for administrators).
     *
     * @return bool|null
     */
    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }
}
