<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SongGroup;

class SongBundlesController extends Controller
{
    public function indexAction()
    {
        $bundles = $this->getDoctrine()
            ->getRepository('AppBundle:SongGroup')
            ->findAll();

        return $this->render('songs/bundles/index.html.twig', [
            'bundles' => $bundles,
        ]);
    }
}