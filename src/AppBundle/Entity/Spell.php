<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Spell
 *
 * @ORM\Table(name="spell")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpellRepository")
 */
class Spell
{
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="range", type="string", length=255, nullable=true)
     */
    private $range;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255)
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="castingTime", type="string", length=255)
     */
    private $castingTime;

    /**
     * @var bool
     *
     * @ORM\Column(name="ritual", type="boolean", nullable=true)
     */
    private $ritual;

    /**
     * @var bool
     *
     * @ORM\Column(name="concentration", type="boolean", nullable=true)
     */
    private $concentration;

    /**
     * @var string
     *
     * @ORM\Column(name="components", type="string", length=255, nullable=true)
     */
    private $components;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CharacterClass", mappedBy="spells")
     */
    private $characterClasses;

    function __construct()
    {
        $this->characterClasses = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Spell
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Spell
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set school
     *
     * @param string $school
     *
     * @return Spell
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set castingTime
     *
     * @param string $castingTime
     *
     * @return Spell
     */
    public function setCastingTime($castingTime)
    {
        $this->castingTime = $castingTime;

        return $this;
    }

    /**
     * Get castingTime
     *
     * @return string
     */
    public function getCastingTime()
    {
        return $this->castingTime;
    }

    /**
     * Set ritual
     *
     * @param boolean $ritual
     *
     * @return Spell
     */
    public function setRitual($ritual)
    {
        $this->ritual = $ritual;

        return $this;
    }

    /**
     * Get ritual
     *
     * @return bool
     */
    public function getRitual()
    {
        return $this->ritual;
    }

    /**
     * Set concentration
     *
     * @param boolean $concentration
     *
     * @return Spell
     */
    public function setConcentration($concentration)
    {
        $this->concentration = $concentration;

        return $this;
    }

    /**
     * Get concentration
     *
     * @return bool
     */
    public function getConcentration()
    {
        return $this->concentration;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Spell
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set range
     *
     * @param string $range
     *
     * @return Spell
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Set components
     *
     * @param string $components
     *
     * @return Spell
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * Get components
     *
     * @return string
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Spell
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return ArrayCollection
     */
    public function getCharacterClasses()
    {
        return $this->characterClasses;
    }

    /**
     * @param ArrayCollection $characterClasses
     */
    public function setCharacterClasses($characterClasses)
    {
        $this->characterClasses = $characterClasses;
    }
}

