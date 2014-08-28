<?php

namespace Wecamp\Recall\Core;

/**
 * Events are changes in the system
 *
 */
class Event
{
    /**
     * @var string $eventIdentifier
     */
    protected $eventIdentifier;

    /**
     * @var int $timestamp
     */
    protected $timestamp;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var int $insertions
     */
    protected $insertions = 0;

    /**
     * @var int $deletions
     */
    protected $deletions = 0;

    /**
     * @var Context $entryContext
     */
    protected $entryContext;

    /**
     * @var Identifier $entryIdentifier
     */
    protected $entryIdentifier;

    /**
     * @param string $eventIdentifier
     * @param User $user
     * @param int $timestamp
     * @param string $description
     * @param int $insertions
     * @param int $deletions
     * @param Context $entryContext
     * @param Identifier $entryIndetifier
     */
    public function __construct(
        $eventIdentifier,
        User $user,
        $timestamp,
        $description,
        $insertions,
        $deletions,
        Context $entryContext,
        Identifier $entryIndetifier
    ) {
        $this->eventIdentifier = $eventIdentifier;
        $this->user = $user;
        $this->timestamp = $timestamp;
        $this->description = $description;
        $this->insertions = $insertions;
        $this->deletions = $deletions;
        $this->entryContext = $entryContext;
        $this->entryIdentifier = $entryIndetifier;
    }

    /**
     * @return string
     */
    public function getEventIdentifier()
    {
        return $this->eventIdentifier;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getDeletions()
    {
        return $this->deletions;
    }

    /**
     * @return int
     */
    public function getInsertions()
    {
        return $this->insertions;
    }

    /**
     * @return Context
     */
    public function getEntryContext()
    {
        return $this->entryContext;
    }

    /**
     * @return Identifier
     */
    public function getEntryIdentifier()
    {
        return $this->entryIdentifier;
    }
}
