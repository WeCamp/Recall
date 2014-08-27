<?php

namespace Wecamp\Recall\Core;

/**
 * Class Data
 * Encapsulates data which can be persisted serialized
 *
 * @package Wecamp\Recall\Core
 */
abstract class Data implements \Serializable
{
    /**
     * Constructor
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->setData($data);
    }

    /**
     * @param mixed $data
     * @throws \DomainException
     */
    public function setData($data)
    {
        if (!$data) {
            throw new \DomainException("Don't fuck with your brain, pal. It ain't worth it.");
        }
        $this->data = $data;
    }

    /**
     * @return mixed $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string $string
     */
    public function __toString()
    {
        return $this->serialize($this->getData());
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    abstract public function serialize();

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    abstract public function unserialize($serialized);
}