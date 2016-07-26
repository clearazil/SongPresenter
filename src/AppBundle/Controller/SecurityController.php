<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\LoginType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Validator\Constraints\NotBlank;
use AppBundle\Validator\Constraints\EmailExists;

class SecurityController extends Controller
{
    public function loginAction(Request $request, $standardView = true)
    {
        $authUtils = $this->get('security.authentication_utils');

        $defaultData = ['username' => $authUtils->getLastUsername()];
        $login = $this->createForm(LoginType::class, $defaultData, ['action' => $this->generateUrl('login')]);

        if(!is_null($authUtils->getLastAuthenticationError(false))) {
            $login->addError(new \Symfony\Component\Form\FormError(
                $authUtils->getLastAuthenticationError()->getMessageKey()
            ));
        }

        $login->handleRequest($request);

        if($standardView) {
            $session = $request->getSession();
            $messages = $session->getFlashBag()->get('message', array());
            return $this->render('security/check_login.html.twig', [
                'login' => $login->createView(),
                'messages' => $messages,
            ]);           
        }

        return $this->render('security/login.html.twig', [
            'login' => $login->createView(),
        ]);
    }

    public function recoverPasswordAction(Request $request, $standardView = true)
    {   
        $success = false;

        $form = $this->createFormBuilder([], ['translation_domain' => 'forms', 'action' => $this->generateUrl('security_password_recovery')])
            ->setMethod('POST')
            ->add('email', EmailType::class, [
                'label' => 'LABEL_PASSWORD_RECOVERY_EMAIL',
                'constraints' => [
                    new NotBlank(),
                    new EmailExists(),
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'BUTTON_PASSWORD_RECOVERY_SUBMIT'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $success = true;

            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('AppBundle:User')
            ->findOneByEmail($request->get('form')['email']);
            $user->setRecoverPasswordId(bin2hex(random_bytes(20)));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // TO DO:
            // send email

        }

        if ($standardView) {
            return $this->render('security/check_recover_password.html.twig', [
                'form' => $form->createView(),
                'success' => $success,
            ]);
        }

        return $this->render('security/recover_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function changePasswordAction($recoverId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')
            ->findOneByRecover_password_id($recoverId);

        if(is_null($user)) {
            return $this->redirectToRoute('security_password_recovery');
        }

        $form = $this->createFormBuilder($user, ['translation_domain' => 'forms'])
            ->setMethod('POST')
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'first_options' => ['label' => 'LABEL_USER_PASSWORD'],
                    'second_options' => ['label' => 'LABEL_USER_PASSWORD_REPEAT'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'BUTTON_USER_EDIT'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setRecoverPasswordId(null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('message', $this->get('translator')->trans('USERS_MESSAGE_CHANGE_PASSWORD_SUCCESS'));
            return $this->redirectToRoute('login');
        }

        return $this->render('security/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}