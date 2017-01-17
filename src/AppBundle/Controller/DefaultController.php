<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/todolist/web", name="todo_list")
     */
     public function listAction(Request $request)
     {
         $todos = $this->getDoctrine()
         ->getRepository('AppBundle:todo')
         ->findAll();

         return $this->render('Todos/index.html.twig', array(
             'todos' => $todos
         ));
     }
}
