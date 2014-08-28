<?php

namespace Wecamp\Recall\Core;

use Rhumsaa\Uuid\Uuid;

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
    public function __construct($value = null)
    {
        // Generate a value iff none is given
        if ($value === null) {
            $value = (string)Uuid::uuid4();
        }
        $this->value = trim($value, DIRECTORY_SEPARATOR);
    }

    /**
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string $value
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
