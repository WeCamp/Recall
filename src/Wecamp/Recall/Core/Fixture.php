<?php

namespace Wecamp\Recall\Core;

/**
 * Class Fixture
 *
 * @package Wecamp\Recall\Core
 */
abstract class Fixture
{
    protected $data;

    public function __construct($type = 'Json')
    {
        $data = Data::factory($type, $this->getStruct());
    }

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    abstract public function getStruct();
}