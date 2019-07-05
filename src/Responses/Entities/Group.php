<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTime;

class Group
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
     * @var User[]|null
     */
    protected $users;

    /**
     * @var string[]|null
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
     * Create a new group instance.
     *
     * @param string        $uid         Unique group ID
     * @param string        $comment     Group comment
     * @param string        $name        Human-readable group name
     * @param User[]|null   $users       Group users list (optional)
     * @param string[]|null $roles       Group roles list (optional)
     * @param string[]      $tags        Additional group tags
     * @param DateTime      $created_at  Group created at
     * @param string        $created_by  Group creator
     * @param DateTime      $updated_at  Last changes was made at
     * @param string        $updated_by  Last changes was made by
     * @param DateTime      $active_from Active from
     * @param DateTime      $active_to   Active to
     * @param int|null      $id          Internal database identifier (optional, only for administrators)
     * @param bool|null     $deleted     Is deleted flag (optional, only for administrators)
     */
    public function __construct(string $uid,
                                string $comment,
                                string $name,
                                ?array $users,
                                ?array $roles,
                                array $tags,
                                DateTime $created_at,
                                string $created_by,
                                DateTime $updated_at,
                                string $updated_by,
                                DateTime $active_from,
                                DateTime $active_to,
                                ?int $id,
                                ?bool $deleted)
    {
        $this->uid         = $uid;
        $this->comment     = $comment;
        $this->name        = $name;
        $this->users       = $users;
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
     * Get unique group ID.
     *
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Get group comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get human-readable group name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get group users list.
     *
     * @return User[]|null
     */
    public function getUsers(): ?array
    {
        return $this->users;
    }

    /**
     * Get group roles list.
     *
     * @return string[]|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * Get additional group tags.
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
     * Get group creator.
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
}
