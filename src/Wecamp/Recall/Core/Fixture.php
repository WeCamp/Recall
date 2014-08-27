<?php

namespace Wecamp\Recall\Core;
use Wecamp\Recall\Git\GitWrapper;

/**
 * Class Fixture
 *
 * @package Wecamp\Recall\Core
 */
abstract class Fixture
{
    protected $identifier;
    protected $data;

    public function __construct($type = 'Json')
    {
        $this->identifier = new Identifier();
        $this->data = Data::factory($type, $this->getStruct());
    }

    /**
     * @return Serializable
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Identifier $identifier
     */
    public function setIdentifier(Identifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return Identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function persist(Context $context, GitRecall $gitRecall)
    {
        $user = new User('Douglas Quaid', 'richter@rekall.com');
        $entry = new Entry($context, $this->getIdentifier(), $this->getData());
        $gitRecall->addEntry($entry, $user);
    }

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    abstract protected function getStruct();
}