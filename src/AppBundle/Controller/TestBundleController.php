<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestBundleController extends Controller
{
    /**
     * @Route("/testBundle/{name}", name="controller_service")
     */
    public function indexAction($name = "World !")
    {
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]); */

        return $this->forward('app.hello_controller:indexAction', array('name' => $name));

    }
}

