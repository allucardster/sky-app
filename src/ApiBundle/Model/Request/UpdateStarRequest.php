<?php

namespace ApiBundle\Model\Request;

use SkyBundle\Model\Element;
use SkyBundle\Model\Request\UpdateStarRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateStarRequest implements UpdateStarRequestInterface
{
    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var string|null
     */
    private $galaxy = null;

    /**
     * @Assert\Type("float")
     * @var float|null
     */
    private $radius = null;

    /**
     * @Assert\Type("float")
     * @var float|null
     */
    private $temperature = null;

    /**
     * @Assert\Type("float")
     * @var float|null
     */
    private $rotationFrequency = null;

    /**
     * @Assert\Choice(callback={Element::class, "getElementList"}, multiple=true, min=1)
     * @var array|null
     */
    private $atoms = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getGalaxy(): ?string
    {
        return $this->galaxy;
    }

    public function setGalaxy(?string $galaxy): void
    {
        $this->galaxy = $galaxy;
    }

    public function getRadius(): ?float
    {
        return $this->radius;
    }

    public function setRadius($radius): void
    {
        $this->radius = $radius;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature($temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getRotationFrequency(): ?float
    {
        return $this->rotationFrequency;
    }

    public function setRotationFrequency($rotationFrequency): void
    {
        $this->rotationFrequency = $rotationFrequency;
    }

    public function getAtoms(): ?array
    {
        return $this->atoms;
    }

    public function setAtoms(?array $atoms): void
    {
        $this->atoms = $atoms;
    }
}