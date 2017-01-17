<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificationBundleController extends Controller
{
    /**
    * @Route("/testing/notifications", name="bundle_service")
    */

     public function indexAction()
     {

         $notify = $this->get("sample.notify");
         $notify->add("test", array("type" => "instant", "message" => "This is awesome"));
         if ($notify->has("test")) {
             return $this->render('SampleNotificationBundle:Default:index.html.twig', array("notifications" => $notify->get("test")));
         }
         return $this->render('SampleNotificationBundle:Default:index.html.twig',array("notifications" => ""));
     }
}

