<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;

class TimelineController
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

    public function listAction()
    {
        $profile = $this->recall->getEntry(
            new Context('personal'),
            new Identifier('profile')
        );
        $profileData = $profile->getData();

        $timeline = $this->recall->recallTimeline();
        $events = $timeline->getEvents();

        $vars = array(
            'name' => $profileData['name'],
            'gender' => $profileData['gender'],
            'age' => $profileData['age'],
            'professionalGroup' => $profileData['professionalGroup'],
            'timeline' => $events,
        );
        return $this->getTemplate()->render('timeline.html.twig', $vars);
    }
}
