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
     * @param string $eventIdentifier
     * @param string $description
     * @param User   $user
     * @param int    $timestamp
     */
    public function __construct($eventIdentifier, $description, User $user, $timestamp)
    {
        $this->eventIdentifier = $eventIdentifier;
        $this->timestamp = $timestamp;
        $this->user = $user;
        $this->description = $description;
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
}