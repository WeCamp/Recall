<?php

namespace Wecamp\Recall\Core;

/**
 * Entry contains data
 *
 */
class Entry
{
    /**
     * @var Context $context
     */
    protected $context;

    /**
     * @var Identifier $identifier
     */
    protected $identifier;

    /**
     * @var Serializable $data
     */
    protected $data;

    /**
     * Constructor requiring mandatory fields
     *
     * @param Context $context
     * @param Identifier $identifier
     * @param \Serializable $data
     * @throws \DomainException
     */
    public function __construct(Context $context, Identifier $identifier, \Serializable $data)
    {
        $this->context = $context;
        $this->identifier = $identifier;
        $this->data = $data;
    }

    /**
     * @return Context $context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return Identifier $identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return Serializable $data
     */
    public function getData()
    {
        return $this->data;
    }
}