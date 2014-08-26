<?php

namespace Wecamp\Recall\Controller;

use Twig_Environment;

trait TemplateEnabled
{
    /** @var Twig_Environment */
    protected $template;

    /**
     * @param Twig_Environment $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return Twig_Environment
     */
    public function getTemplate()
    {
        return $this->template;
    }


} 