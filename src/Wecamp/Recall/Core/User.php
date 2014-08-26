<?php

namespace Wecamp\Recall\Core;

/**
 * A User is used to identify Events in the system
 *
 */
class User
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $email
     */
    protected $email;

    /**
     * Constructor requiring all the fields
     *
     * @param string $name
     * @param string $email
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
}