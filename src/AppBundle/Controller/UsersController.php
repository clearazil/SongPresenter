<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\UserType;
use AppBundle\Entity\User;

class UsersController extends Controller
{
    public function indexAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }

    public function createAction(Request $request, $register = false)
    {
        if(!$register) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $user = new User();

        $action = $register ? $this->generateUrl('users_register') : $this->generateUrl('users_create');

        $form = $this->createForm(UserType::class, $user, ['action' => $action, 'register' => $register]);

        $form->handleRequest($request);

        if($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users_index');
        }

        if($register) {
            return $this->render('users/register.html.twig', [
                'form' => $form->createView(),
            ]);            
        }

        return $this->render('users/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('users/check_register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')
            ->find($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}