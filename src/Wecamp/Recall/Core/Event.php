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
     * @var Context $entryContext
     */
    protected $entryContext;

    /**
     * @var Identifier $entryIdentifier
     */
    protected $entryIdentifier;

    /**
     * @param string $eventIdentifier
     * @param string $description
     * @param User $user
     * @param int $timestamp
     * @param Context $entryContext
     * @param Identifier $entryIndetifier
     */
    public function __construct(
        $eventIdentifier,
        $description,
        User $user,
        $timestamp,
        Context $entryContext,
        Identifier $entryIndetifier
    ) {
        $this->eventIdentifier = $eventIdentifier;
        $this->timestamp = $timestamp;
        $this->user = $user;
        $this->description = $description;
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
    public function getTimestamp()
    {
        return $this->timestamp;
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
    public function getDescription()
    {
        return $this->description;
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
