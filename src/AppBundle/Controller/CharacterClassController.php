<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CharacterClassController extends Controller
{
    /**
     * @Route("/", name="characterClassIndex")
     *
     * @return Response
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:CharacterClass');

        $characterClasses = $repository->findAll();

        return $this->render('characterClass/index.html.twig', [
            'characterClasses' => $characterClasses,
        ]);
    }
}
