<?php

namespace Wecamp\Recall\Core;

/**
 * Identifier abstraction for a certain Entity
 *
 */
class Identifier
{
    /**
     * @var string $value
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}