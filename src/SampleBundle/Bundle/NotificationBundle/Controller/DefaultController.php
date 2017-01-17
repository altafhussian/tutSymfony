<?php

namespace SampleBundle\Bundle\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SampleNotificationBundle:Default:index.html.twig');
    }
}
