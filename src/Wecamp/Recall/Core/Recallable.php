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
     * Adds an Entity
     *
     * @param  Entity  $entity
     * @param  User    $user
     * @return Entity
     */
    public function addEntity(Entity $entity, User $user);

    /**
     * Returns an entity for a given Context located by it's identifier
     *
     * @param  Context    $context
     * @param  Identifier $identifier
     * @param  null       $version
     * @return Entity
     */
    public function getEntity(Context $context, Identifier $identifier, $version = null);

    /**
     * Recalls the whole timeline for a certain Context
     * If no Context is given, a wildcard is assumed.
     * A.k.a. Total Recall
     *
     * @param  Context $context
     * @return Timeline
     */
    public function recallTimeline(Context $context = null);
}