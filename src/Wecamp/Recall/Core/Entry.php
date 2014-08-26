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
     * @var string $data;
     */
    protected $data;

    /**
     * Constructor requiring mandatory fields
     *
     * @param Context $context
     * @param Identifier $identifier
     * @param string $data
     * @throws \DomainException
     */
    public function __construct(Context $context, Identifier $identifier, $data)
    {
        $this->context = $context;
        $this->identifier = $identifier;
        $this->data = $data;

        if(empty($data)) {
            throw new \DomainException("Don't fuck with your brain, pal. It ain't worth it.");
        }
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
     * @return string $data
     */
    public function getData()
    {
        return $this->data;
    }



}