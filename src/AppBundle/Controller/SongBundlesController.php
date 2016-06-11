<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SongGroup;

use AppBundle\Form\Type\SongBundleType;

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

    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $songBundle = new SongGroup();

        $form = $this->createForm(SongBundleType::class, $songBundle);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($songBundle);
            $em->flush();

            return $this->redirectToRoute('song_bundles_index');
        }

        return $this->render('songs/bundles/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $songBundle = $em->getRepository('AppBundle:SongGroup')
            ->find($id);

        $this->denyAccessUnlessGranted('EDIT', $songBundle);

        $form = $this->createForm(SongBundleType::class, $songBundle);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('song_bundles_index');
        }

        return $this->render('songs/bundles/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}