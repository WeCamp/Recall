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

    public function persist(Context $context)
    {
        $identifier = new Identifier();
        $user = new User('Douglas Quaid', 'richter@rekall.com');
        $entry = new Entry($context, $identifier, $this->getData());
        $gitdir = dirname(__FILE__) . '/../../../../var/data';

        $gitRecall = new GitRecall(new GitWrapper(new \GitWrapper\GitWrapper()), $gitdir);
        $gitRecall->addEntity($entry, $user);
    }

    /**
     * The fixture specific struct should be implemented in the extend
     *
     * @return mixed
     */
    abstract protected function getStruct();
}