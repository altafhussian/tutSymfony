<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SendMail extends Controller
{
    /**
     * @Route("/mail", name="send_mail")
     */
     public function indexAction($name="altaf")
     {
         $message = \Swift_Message::newInstance()
             ->setSubject('Hello Email')
             ->setFrom('blazealtaf@gmail.com')
             ->setTo('blazealtaf@gmail.com')
             ->setBody(
                 $this->renderView(
                     // app/Resources/views/Email/email.html.twig
                     'Email/email.html.twig',
                     array('name' => $name)
                 ),
                 'text/html'
             );
             /*
              * If you also want to include a plaintext version of the message
             ->addPart(
                 $this->renderView(
                     'Emails/registration.txt.twig',
                     array('name' => $name)
                 ),
                 'text/plain'
             )
             */

         $res = $this->get('mailer')->send($message);

         return $this->render('Email/message.html.twig', array('result' => $res));
     }
}
