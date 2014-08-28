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
     * @param string $contextName
     * @param string $entryIdentifier
     * @return string
     */
    public function displayAction($contextName, $entryIdentifier)
    {
        // The forward slashes ("/") in the context are replaced with underscores ("_"). This has to be reverted for
        // the context to work again.
        $contextName = str_replace("_", "/", $contextName);

        // The eventIdentifier can have the version attached to it, separated with an @ character, so we need to
        // explode it out
        $explodedEntryData = explode("@", $entryIdentifier);
        list($entryIdentifier, $eventIdentifier) = $explodedEntryData;

        $entry = $this->recall->getEntry(
            new Context($contextName),
            new Identifier($entryIdentifier),
            $eventIdentifier
        );

        var_dump($entry); die();

        $vars = [
            'entry' => $entry
        ];
        return $this->getTemplate()->render('entryDisplay.html.twig', $vars);
    }
} 