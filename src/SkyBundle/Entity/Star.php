<?php

namespace SkyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Star
 *
 * @ORM\Table(
 *     name="tbl_star",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="tbl_star_name_galaxy_unq", columns={"name", "galaxy"}
 *     )
 * })
 * @ORM\Entity(repositoryClass="SkyBundle\Repository\StarRepository")
 */
class Star
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="galaxy", type="string", length=255)
     */
    private $galaxy;

    /**
     * @var float
     *
     * @ORM\Column(name="radius", type="float")
     */
    private $radius;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float")
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="rotation_frequency", type="float")
     */
    private $rotationFrequency;

    /**
     * @var array
     *
     * @ORM\Column(name="atoms", type="json")
     */
    private $atoms;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Star
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set galaxy
     *
     * @param string $galaxy
     *
     * @return Star
     */
    public function setGalaxy(string $galaxy): self
    {
        $this->galaxy = $galaxy;

        return $this;
    }

    /**
     * Get galaxy
     *
     * @return string
     */
    public function getGalaxy(): string
    {
        return $this->galaxy;
    }

    /**
     * Set radius
     *
     * @param float $radius
     *
     * @return Star
     */
    public function setRadius(float $radius): self
    {
        $this->radius = $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return float
     */
    public function getRadius(): float
    {
        return $this->radius;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     *
     * @return Star
     */
    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * Set rotationFrequency
     *
     * @param float $rotationFrequency
     *
     * @return Star
     */
    public function setRotationFrequency(float $rotationFrequency): self
    {
        $this->rotationFrequency = $rotationFrequency;

        return $this;
    }

    /**
     * Get rotationFrequency
     *
     * @return float
     */
    public function getRotationFrequency(): float
    {
        return $this->rotationFrequency;
    }

    /**
     * Set atoms
     *
     * @param array $atoms
     *
     * @return Star
     */
    public function setAtoms(array $atoms): self
    {
        $this->atoms = $atoms;

        return $this;
    }

    /**
     * Get atoms
     *
     * @return array
     */
    public function getAtoms(): array
    {
        return $this->atoms;
    }
}

