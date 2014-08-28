<?php

namespace Wecamp\Recall\Core;

/**
 * A User is used to identify Events in the system
 *
 */
class User implements \JsonSerializable
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

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }
}