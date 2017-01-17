<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class HelloController
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
     $this->templating = $templating;
    }

    public function indexAction($name)
    {
     return $this->templating->renderResponse(
            'Hello\index.html.twig',
            array('name' => $name)
     );
    }
}
