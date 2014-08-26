<?php

namespace Wecamp\Recall\Controller;

class TimelineController
{
    use TemplateEnabled;

    public function listAction()
    {
        return $this->getTemplate()->render('timeline.html.twig');
    }
} 