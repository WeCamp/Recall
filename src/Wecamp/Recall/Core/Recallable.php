<?php

namespace Wecamp\Recall\Core;

/**
 * Interface Recallable
 *
 *
 * @package Wecamp\Recall\Core
 */
interface Recallable
{
    /**
     * Adds an Entry
     *
     * @param  Entry $entry
     * @param  User $user
     * @param  string $description
     * @return Entry
     */
    public function addEntry(Entry $entry, User $user, $description, $version = null);

    /**
     * Returns an Entry for a given Context located by its identifier
     *
     * @param  Context $context
     * @param  Identifier $identifier
     * @param  null $version
     * @return Entry
     */
    public function getEntry(Context $context, Identifier $identifier, $version = null);

    /**
     * Recalls the whole timeline for a certain Context
     * If no Context is given, a wildcard is assumed.
     * A.k.a. Total Recall
     *
     * @param  Context $context
     * @param string $branch
     * @return Timeline
     */
    public function recallTimeline(Context $context = null, $branch = 'master');

    /**
     * @return string $uuid
     */
    public function changeRequest();

    /**
     * @return string[]
     */
    public function listChangeRequests();

    /**
     * @param $branch
     * @return null
     */
    public function acceptChangeRequest($branch);

    /**
     * @param $branch
     * @return null
     */
    public function denyChangeRequest($branch);
}
