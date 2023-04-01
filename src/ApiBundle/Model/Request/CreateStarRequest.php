<?php

namespace ApiBundle\Model\Request;

use SkyBundle\Model\Request\CreateStarRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;
use SkyBundle\Model\Element;

class CreateStarRequest implements CreateStarRequestInterface
{
    /**
     * @Assert\NotBlank
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @var string
     */
    public $galaxy;

    /**
     * @Assert\NotNull
     * @Assert\Type("float")
     * @var float
     */
    private $radius = 0.0;

    /**
     * @Assert\NotNull
     * @Assert\Type("float")
     * @var float
     */
    private $temperature = 0.0;

    /**
     * @Assert\NotNull
     * @Assert\Type("float")
     * @var float
     */
    private $rotationFrequency = 0.0;

    /**
     * @Assert\NotNull
     * @Assert\Choice(callback={Element::class, "getElementList"}, multiple=true)
     * @var array
     */
    private $atoms = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getGalaxy(): string
    {
        return $this->galaxy;
    }

    public function setGalaxy($galaxy): void
    {
        $this->galaxy = $galaxy;
    }
    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius($radius): void
    {
        $this->radius = $radius;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature($temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getRotationFrequency(): float
    {
        return $this->rotationFrequency;
    }

    public function setRotationFrequency($rotationFrequency): void
    {
        $this->rotationFrequency = $rotationFrequency;
    }

    public function getAtoms(): array
    {
        return $this->atoms;
    }

    public function setAtoms($atoms): void
    {
        $this->atoms = $atoms;
    }
}