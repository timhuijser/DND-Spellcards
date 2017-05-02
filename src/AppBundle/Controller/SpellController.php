<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SpellController extends Controller
{
    /**
     * @Route("/spells", name="spellIndex")
     *
     * @return Response
     */
    public function indexAction()
    {
        $spellRepository = $this->getDoctrine()->getRepository('AppBundle:Spell');

        $spells = $spellRepository->findAll();

        return $this->render('spell/index.html.twig', [
            'spells' => $spells,
        ]);
    }

    /**
     * @Route("/spells/class/{characterClass}", name="spellsForCharacterClass")
     *
     * @param $characterClass
     * @return Response
     */
    public function characterAction($characterClass)
    {
        $spellRepository = $this->getDoctrine()->getRepository('AppBundle:Spell');

        $spells = $spellRepository->findByCharacterClass($characterClass);

        return $this->render('spell/index.html.twig', [
            'spells' => $spells,
        ]);
    }
}
