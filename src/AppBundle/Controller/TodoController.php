<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use AppBundle\Entity\todo;

class TodoController extends Controller
{
    /**
     * @Route("/list", name="todo_list")
     */

    public function listAction(Request $request)
    {
        $todos = $this->getDoctrine()
        ->getRepository('AppBundle:todo')
        ->findBy(array('userId' => 1));

        return $this->render('Todos/index.html.twig', array(
            'todos' => $todos
        ));
    }

   /**
    * @Route("/todos/create", name="todo_create")
    */
   public function createAction(Request $request)
   {
      $todo = new Todo;

      $form = $this->createFormBuilder($todo)
      ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
      ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
      ->add('description', null, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
      // ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High'=>'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
      ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;display:inline-flex')))
      ->add('Save', SubmitType::class, array('label'=> 'Create Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px;float: left;background:#4d4d4d;border-color:#333333;')))
      //->add('Cancel', SubmitType::class, array('label'=> 'Cancel', 'attr' => array('class' => 'btn btn-default', 'style' => 'margin-bottom:15px; margin-left: 10px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() &&  $form->isValid()){
          $name = $form['name']->getData();
          $category = $form['category']->getData();
          $description = $form['description']->getData();
          $due_date = $form['due_date']->getData();
          $due_date->format('Y-m-d');

          $name = $form['name']->getData();

          $user_id = 1;

          $name = $form['name']->getData();

          $now = new\DateTime('now');

          $todo->setName($name);
          $todo->setCategory($category);
          $todo->setDescription($description);
          $todo->setDuedate($due_date);
          $todo->setCreateDate($now);
          $todo->setUserId($user_id);

          $sn = $this->getDoctrine()->getManager();
          $sn -> persist($todo);
          $sn -> flush();

          $this->addFlash(
              'notice',
              'Todo Added'
          );
          return $this->redirectToRoute('todo_list');

      }

      return $this->render('Todos/create.html.twig', array(
          'form' => $form->createView()

      ));
   }

   /**
    * @Route("/todos/details/{id}", name="todo_details", requirements={"id" = "\d+"})
    */
   public function detailsAction($id = 1)
   {
      $todos = $this->getDoctrine()
       ->getRepository('AppBundle:todo')
       ->find($id);

       return $this->render('Todos/details.html.twig', array(
           'todo' => $todos
       ));
   }

   /**
     * @Route("/todos/edit/{id}", name="todo_edit", requirements={"id" = "\d+"})
     */
    public function editAction($id,Request $request)
    {
         $now = new\DateTime('now');
         $todo = $this->getDoctrine()
         ->getRepository('AppBundle:todo')
         ->find($id);

          $todo->setName($todo->getName());
          $todo->setCategory($todo->getCategory());
          $todo->setDescription($todo->getDescription());
          $todo->setDuedate($todo->getDueDate());
          $todo->setCreateDate($now);

        $form = $this->createFormBuilder($todo)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('description', null, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;display:inline-flex')))
        ->add('Save', SubmitType::class, array('label'=> 'Update Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px; float: left;background:#4d4d4d;border-color:#333333;')))
        //->add('Cancel', SubmitType::class, array('label'=> 'Cancel', 'attr' => array('class' => 'btn btn-default', 'style' => 'margin-bottom:15px; margin-left: 10px')))
        ->getForm();

        $form->handleRequest($request);
/*        if ($form->get('Cancel')->isClicked()) {
            return $this->redirectToRoute('todo_list');
        } */

        if($form->isSubmitted() &&  $form->isValid()){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $due_date = $form['due_date']->getData();
            $name = $form['name']->getData();


            $sn = $this->getDoctrine()->getManager();
            $todo = $sn->getRepository('AppBundle:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setDuedate($due_date);
            $todo->setCreateDate($now);

            $sn -> flush();

            $this->addFlash(
                'notice',
                'Todo Updated'
            );
            return $this->redirectToRoute('todo_list');

        }

        return $this->render('Todos/edit.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView()
        ));

    }

    /**
    * @Route("/todos/delete/{id}", name="todo_delete",  requirements={"id" = "\d+"})
    */
   public function deleteAction($id)
   {
        $sn = $this->getDoctrine()->getManager();
        $todo = $sn->getRepository('AppBundle:todo')->find($id);

        $sn->remove($todo);
        $sn->flush();
       //  $todos = $this->getDoctrine()
       // ->getRepository('AppBundle:Todo')
       // ->find($id);

        $this->addFlash(
               'notice',
               'Todo Removed'
           );
         return $this->redirectToRoute('todo_list');
   }
}

?>
