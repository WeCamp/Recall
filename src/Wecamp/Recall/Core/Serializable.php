<?php

namespace Wecamp\Recall\Core;

/**
 * Interface Serializable
 *
 * @package Wecamp\Recall\Core
 */
interface Serializable extends \Serializable
{
    /**
     * @param mixed $data
     */
    public function __construct($data);

    /**
     * @return mixed
     */
    public function getData();
}