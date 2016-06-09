<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    public function localeAction($_locale, Request $request)
    {
        $session = $request->getSession();
        $lastRoute = $session->get('last_route', ['name' => 'homepage', 'params' => []]);
        
        return $this->redirectToRoute($lastRoute['name'], $lastRoute['params']);
    }
}
