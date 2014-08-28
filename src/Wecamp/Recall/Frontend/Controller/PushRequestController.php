<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Core\Context;
use Wecamp\Recall\Core\Identifier;
use Wecamp\Recall\Core\Recallable;
use Wecamp\Recall\Fixture\Personal\Profile;

class PushRequestController
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
        // get profile
        $profile = $this->recall->getEntry(new Context('personal'), new Identifier('profile'));
        $profileData = $profile->getData();


        $branches = $this->recall->listChangeRequests();

        $pushRequests = [];
        foreach($branches as $branch) {
            $timeline = $this->recall->recallTimeline(null, $branch);
            $pushRequests[] = [
                'branch' => $branch,
                'event' => $timeline->getEvents()[0]
            ];
        }

        // render
        return $this->getTemplate()->render(
            'pushrequests.html.twig',
            array(
                'profile' => $profileData['data'],
                'pushrequests' => $pushRequests
            )
        );
    }

    public function showAction($branch)
    {

    }

    public function acceptAction($branch)
    {
        $this->recall->acceptChangeRequest($branch);

        header("Location: /pushrequests");
        exit;
    }

    public function denyAction($branch)
    {
        $this->recall->denyChangeRequest($branch);

        header("Location: /pushrequests");
        exit;
    }
}
