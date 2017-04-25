<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterClass
 *
 * @ORM\Table(name="character_class")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CharacterClassRepository")
 */
class CharacterClass
{
    const BARBARIAN = 'barbarian';
    const BARD = 'bard';
    const CLERIC = 'cleric';
    const DRUID = 'druid';
    const FIGHTER = 'fighter';
    const MONK = 'monk';
    const PALADIN = 'paladin';
    const RANGER = 'ranger';
    const ROGUE = 'rogue';
    const SORCERER = 'sorcerer';
    const WARLOCK = 'warlock';
    const WIZARD = 'wizard';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Spell", inversedBy="characterClasses")
     * @ORM\JoinTable(name="character_class_spells")
     */
    private $spells;

    function __construct()
    {
        $this->spells = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CharacterClass
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CharacterClass
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public static function getSlugs() {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }

    /**
     * @return ArrayCollection
     */
    public function getSpells()
    {
        return $this->spells;
    }

    /**
     * @param ArrayCollection $spells
     */
    public function setSpells($spells)
    {
        $this->spells = $spells;
    }

    /**
     * @param $spell
     */
    public function addSpell($spell)
    {
        $this->spells->add($spell);
    }
}

