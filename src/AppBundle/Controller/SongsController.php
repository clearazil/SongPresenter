<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\SongType;
use AppBundle\Entity\Song;
use AppBundle\Entity\SongVerse;

class SongsController extends Controller
{
    public function createAction(Request $request)
    {
        $song = new Song();

        $songVerse = new SongVerse();
        $song->addVerse($songVerse);

        $form = $this->createForm(SongType::class, $song);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();
        }

        $i = 0;

        return $this->render('songs/create.html.twig', [
            'form' => $form->createView(),
            'i' => $i,
        ]);
    }

    public function editAction($id, Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $song = $em->getRepository('AppBundle:Song')
            ->find($id);

        $form = $this->createForm(SongType::class, $song);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();
        }

        $i = 0;

        return $this->render('songs/edit.html.twig', [
            'form' => $form->createView(),
            'i' => $i,
        ]);
    }
}