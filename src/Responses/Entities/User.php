<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTime;
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
     * @var string[]
     */
    protected $roles;

    /**
     * @var string[]
     */
    protected $tags;

    /**
     * @var DateTime
     */
    protected $created_at;

    /**
     * @var string
     */
    protected $created_by;

    /**
     * @var DateTime
     */
    protected $updated_at;

    /**
     * @var string
     */
    protected $updated_by;

    /**
     * @var DateTime
     */
    protected $active_from;

    /**
     * @var DateTime
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
     * @param string      $uid         Unique user ID
     * @param string      $comment     User comment
     * @param string      $contacts    User contact info
     * @param string      $email       User email
     * @param string      $login       Login (e.g. `user@domain`)
     * @param string      $name        Human-readable user name
     * @param string      $state       User status (e.g.: `ACTIVATION_REQUIRED`, `ACTIVE`, `BANNED`)
     * @param string      $domain_uid  User domain unique ID
     * @param Domain|null $domain      User domain object (optional)
     * @param string[]    $roles       User roles
     * @param string[]    $tags        Additional user tags
     * @param DateTime    $created_at  User created at
     * @param string      $created_by  User creator
     * @param DateTime    $updated_at  Last changes was made at
     * @param string      $updated_by  Last changes was made by
     * @param DateTime    $active_from Active from
     * @param DateTime    $active_to   Active to
     * @param int|null    $id          Internal database identifier (optional, only for administrators)
     * @param bool|null   $deleted     Is deleted flag (optional, only for administrators)
     * @param string|null $pass_hash   Password hash (optional, only for administrators)
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
                                DateTime $created_at,
                                string $created_by,
                                DateTime $updated_at,
                                string $updated_by,
                                DateTime $active_from,
                                DateTime $active_to,
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
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
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
            DateTimeFactory::createFromIso8601Zulu($data['created_at']),
            $data['created_by'],
            DateTimeFactory::createFromIso8601Zulu($data['updated_at']),
            $data['updated_by'],
            DateTimeFactory::createFromIso8601Zulu($data['active_from']),
            DateTimeFactory::createFromIso8601Zulu($data['active_to']),
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
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Get additional user tags.
     *
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Get created at date/time.
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
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
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
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
     * @return DateTime
     */
    public function getActiveFrom(): DateTime
    {
        return $this->active_from;
    }

    /**
     * Get active to date/time.
     *
     * @return DateTime
     */
    public function getActiveTo(): DateTime
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
