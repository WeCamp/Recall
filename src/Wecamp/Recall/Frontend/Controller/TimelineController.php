<?php

namespace Wecamp\Recall\Frontend\Controller;

class TimelineController
{
    use TemplateEnabled;

    public function listAction()
    {
        return $this->getTemplate()->render('timeline.html.twig', array(
            'name' => 'Fred',
            'gender' => 'Male',
            'age' => 26,
            'professionalGroup' => 'Tester at Big Technical Corp.',
            'timeline' => array(
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
            )
        ));
    }
}
