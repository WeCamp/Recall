<?php

namespace Wecamp\Recall\Frontend\Controller;

use Wecamp\Recall\Fixture\Personal\Profile;
use Wecamp\Recall\Core\Context;

class TimelineController
{
    use TemplateEnabled;

    public function listAction()
    {
        $profile = new Profile();
        $data = $profile->getData();

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

        $profile->persist(new Context('Personal/Profile'));
        print_r($profile);

        $vars = array(
            'name' => $data['name'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'professionalGroup' => $data['professionalGroup'],
            'timeline' => $timeline,
        );
        return $this->getTemplate()->render('timeline.html.twig', $vars);
    }
}
