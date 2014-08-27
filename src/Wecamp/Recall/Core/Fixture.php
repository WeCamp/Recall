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
        $this->data = Data::factory($type, $this->getStruct());
    }

    /**
     * @return Serializable
     */
    public function getData()
    {
        return $this->data;
    }

    public function persist()
    {

    }

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    abstract protected function getStruct();
}