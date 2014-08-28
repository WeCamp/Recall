<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;
use Wecamp\Recall\Fixture\Personal\Profile;

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
        // create profile
        $profile = new Profile();
        $profile->persist(new Context('personal'), $this->recall, "Profile created");

        // get profile
        $profile = $this->recall->getEntry(new Context('personal'), new Identifier('profile'));
        $profileData = $profile->getData();

        // get timeline
        $timeline = $this->recall->recallTimeline();

        // render
        return $this->getTemplate()->render(
            'timeline.html.twig',
            array(
                'profile' => $profileData['data'],
                'timeline' => $timeline
            )
        );
    }
}
