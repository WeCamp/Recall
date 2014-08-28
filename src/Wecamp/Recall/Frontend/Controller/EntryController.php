<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;

class EntryController
{
    use TemplateEnabled;

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
     * @param $contextName
     * @param $entryIdentifier
     * @internal param string $eventIdentifier
     * @return string
     */
    public function displayAction($contextName, $entryIdentifier)
    {
        // The forward slashes ("/") in the context are replaced with underscores ("_"). This has to be reverted for
        // the context to work again.
        $contextName = str_replace("_", "/", $contextName);

        $entry = $this->recall->getEntry(
            new Context($contextName),
            new Identifier($entryIdentifier)
        );

        $vars = [
            'entry' => $entry
        ];
        return $this->getTemplate()->render('entryDisplay.html.twig', $vars);
    }
} 