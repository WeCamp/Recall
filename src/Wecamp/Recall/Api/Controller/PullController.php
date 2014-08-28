<?php

namespace Wecamp\Recall\Api\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Data;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;

class PullController
{
    /** @var Recallable */
    private $recall;

    /**
     * @param Recallable $recall
     */
    public function __construct(Recallable $recall)
    {
        $this->recall = $recall;
    }

    /**
     * @param string $contextName
     * @return string
     */
    public function getAction($contextName)
    {
        @list($contextName, $version) = explode('@', $contextName);
        $contextName = explode("_", $contextName);
        $identifierName = array_pop($contextName);
        $contextName = implode(DIRECTORY_SEPARATOR, $contextName);

        $context = new Context($contextName);
        $identifier = new Identifier($identifierName);

        $entry = $this->recall->getEntry($context, $identifier, $version);


        return json_encode($entry->getData()->getData());
    }
}
