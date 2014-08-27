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

        $timeline = array(
            array(
                'timestamp' => 1409068419,
                'description' => 'Bob added a recipe',
            ),
            array(
                'timestamp' => 1409068419,
                'description' => 'Alice verified a recipe',
            ),
            array(
                'timestamp' => 1409068419,
                'description' => 'Alice pulled a recipe',
            ),
        );

        $vars = array(
            'name' => $profileData['name'],
            'gender' => $profileData['gender'],
            'age' => $profileData['age'],
            'professionalGroup' => $profileData['professionalGroup'],
            'timeline' => $timeline,
        );
        return $this->getTemplate()->render('timeline.html.twig', $vars);
    }
}
