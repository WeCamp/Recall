<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Entry;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;
use Wecamp\Recall\Core\User;
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
        $this->initProfile();

        // get profile
        $profile = $this->recall->getEntry(new Context('personal'), new Identifier('profile'));
        $profileData = $profile->getData();

        // get timeline
        $timeline = $this->recall->recallTimeline();

        // render
        return $this->getTemplate()->render(
            'timeline.html.twig',
            array(
                'profile' => $profileData->getData(),
                'timeline' => $timeline
            )
        );
    }

    protected function initProfile()
    {
        $profile = new Profile();
        $entry = new Entry(
            new Context('personal'),
            new Identifier('profile'),
            $profile->getData()
        );

        $user = new User('Douglas Quaid', 'richter@rekall.com');

        $description = "Profile created";

        $this->recall->addEntry(
            $entry,
            $user,
            $description
        );
    }
}
