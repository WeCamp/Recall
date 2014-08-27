<?php

namespace Wecamp\Recall\Core;
use Symfony\Component\Process\Exception\RuntimeException;

/**
 * Class Data
 * Encapsulates data which can be persisted serialized
 *
 * @package Wecamp\Recall\Core
 */
abstract class Data implements Serializable, \ArrayAccess, \Countable
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

    /**
     * @param  string $type
     * @param  mixed $data
     * @throws \RuntimeException
     * @return Serializable
     */
    public static function factory($type, $data)
    {
        $class = __NAMESPACE__ . '\\Data\\' . $type;

        $object = null;
        if(class_exists($class)) {
            $object = new $class($data);
        }

        if($object === null) {
            throw new \RuntimeException("Unable to instantiate object of class '" . $class . "'");
        }

        return $object;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return sizeof($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}