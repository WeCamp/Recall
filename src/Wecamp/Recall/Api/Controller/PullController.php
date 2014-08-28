<?php

namespace Wecamp\Recall\Api\Controller;

use Wecamp\Recall\Core\Context;
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
     * @param string|null $entryIdentifier
     * @return string
     */
    public function getAction($contextName, $entryIdentifier = null)
    {
        $contextName = str_replace("_", "/", $contextName);
        $context = new Context($contextName);

        if (is_null($entryIdentifier)) {
            return $this->getTimelineForContext($context);
        }

        return $this->getEntryForContext($context, $entryIdentifier);
    }

    /**
     * @param Context $context
     * @param $entryIdentifier
     * @return string
     */
    protected function getEntryForContext(Context $context, $entryIdentifier)
    {
        $explodedEntryData = explode("@", $entryIdentifier);
        @list($entryIdentifier, $eventIdentifier) = $explodedEntryData;

        $entry = $this->recall->getEntry(
            $context,
            new Identifier($entryIdentifier),
            $eventIdentifier
        );

        return json_encode(array(
            'contextName' => $context->getName(),
            'identifier' => $entry->getIdentifier()->getValue(),
            'data' => $entry->getData()->getData(),
        ));
    }

    /**
     * @param Context $context
     * @return string
     */
    protected function getTimelineForContext(Context $context)
    {
        $timeline = $this->recall->recallTimeline($context);

        return json_encode($timeline, true);
    }
}
