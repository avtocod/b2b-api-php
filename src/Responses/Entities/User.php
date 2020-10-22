<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTimeImmutable;
use Avtocod\B2BApi\DateTimeFactory;

class User implements CanCreateSelfFromArrayInterface
{
    /**
     * User state - activation is required.
     */
    public const STATE_ACTIVATION_REQUIRED = 'ACTIVATION_REQUIRED';

    /**
     * User state - active.
     */
    public const STATE_ACTIVE = 'ACTIVE';

    /**
     * User state - banned.
     */
    public const STATE_BANNED = 'BANNED';

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
    protected $contacts;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $domain_uid;

    /**
     * @var Domain|null
     */
    protected $domain;

    /**
     * @var array<string>
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
     * @var string|null
     */
    protected $pass_hash;

    /**
     * Create a new user instance.
     *
     * @param string            $uid         Unique user ID
     * @param string            $comment     User comment
     * @param string            $contacts    User contact info
     * @param string            $email       User email
     * @param string            $login       Login (e.g. `user@domain`)
     * @param string            $name        Human-readable user name
     * @param string            $state       User status (e.g.: `ACTIVATION_REQUIRED`, `ACTIVE`, `BANNED`)
     * @param string            $domain_uid  User domain unique ID
     * @param Domain|null       $domain      User domain object (optional)
     * @param array<string>     $roles       User roles
     * @param array<string>     $tags        Additional user tags
     * @param DateTimeImmutable $created_at  User created at
     * @param string            $created_by  User creator
     * @param DateTimeImmutable $updated_at  Last changes was made at
     * @param string            $updated_by  Last changes was made by
     * @param DateTimeImmutable $active_from Active from
     * @param DateTimeImmutable $active_to   Active to
     * @param int|null          $id          Internal database identifier (optional, only for administrators)
     * @param bool|null         $deleted     Is deleted flag (optional, only for administrators)
     * @param string|null       $pass_hash   Password hash (optional, only for administrators)
     */
    public function __construct(string $uid,
                                string $comment,
                                string $contacts,
                                string $email,
                                string $login,
                                string $name,
                                string $state,
                                string $domain_uid,
                                ?Domain $domain,
                                array $roles,
                                array $tags,
                                DateTimeImmutable $created_at,
                                string $created_by,
                                DateTimeImmutable $updated_at,
                                string $updated_by,
                                DateTimeImmutable $active_from,
                                DateTimeImmutable $active_to,
                                ?int $id,
                                ?bool $deleted,
                                ?string $pass_hash)
    {
        $this->uid         = $uid;
        $this->comment     = $comment;
        $this->contacts    = $contacts;
        $this->email       = $email;
        $this->login       = $login;
        $this->name        = $name;
        $this->state       = $state;
        $this->domain_uid  = $domain_uid;
        $this->domain      = $domain;
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
        $this->pass_hash   = $pass_hash;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['uid'],
            $data['comment'],
            $data['contacts'],
            $data['email'],
            $data['login'],
            $data['name'],
            $data['state'],
            $data['domain_uid'],
            isset($data['domain'])
                ? Domain::fromArray($data['domain'])
                : null,
            \array_filter(\explode(',', $data['roles'])),
            \array_filter(\explode(',', $data['tags'])),
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['created_at'])),
            $data['created_by'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['updated_at'])),
            $data['updated_by'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['active_from'])),
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($data['active_to'])),
            $data['id'] ?? null,
            $data['deleted'] ?? null,
            $data['pass_hash'] ?? null
        );
    }

    /**
     * Get unique user ID.
     *
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Get user comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get user contact info.
     *
     * @return string
     */
    public function getContacts(): string
    {
        return $this->contacts;
    }

    /**
     * Get user email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get login.
     *
     * @return string E.g. `user@domain`
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Get human-readable user name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get user status.
     *
     * @return string E.g.: `ACTIVATION_REQUIRED`, `ACTIVE`, `BANNED`
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get user domain unique ID.
     *
     * @return string
     */
    public function getDomainUid(): string
    {
        return $this->domain_uid;
    }

    /**
     * Get user domain object.
     *
     * @return Domain|null
     */
    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    /**
     * Get user roles list.
     *
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Get additional user tags.
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
     * Get user creator.
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

    /**
     * Get password hash (only for administrators).
     *
     * @return string|null
     */
    public function getPassHash(): ?string
    {
        return $this->pass_hash;
    }
}
