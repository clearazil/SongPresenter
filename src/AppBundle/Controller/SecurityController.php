<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\LoginType;

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
            return $this->render('security/check_login.html.twig', [
                'login' => $login->createView(),
            ]);           
        }

        return $this->render('security/login.html.twig', [
            'login' => $login->createView(),
        ]);
    }
}