<?php

namespace Wecamp\Recall\Core;

/**
 * Context is applied as a form of a 'namespace'.
 * Too bad PHP has a reserved keyword for somewhat the same purpose.
 */
class Context
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $name
     */
    public function __toString()
    {
        return $this->getName();
    }
}