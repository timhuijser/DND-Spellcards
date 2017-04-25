<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CharacterClass as CharacterClassEntity;

class CharacterClass implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach (CharacterClassEntity::getSlugs() as $slug) {
            $characterClass = new CharacterClassEntity;
            $characterClass->setName(ucfirst($slug));
            $characterClass->setSlug($slug);

            $manager->persist($characterClass);
        }

        $manager->flush();
    }
}