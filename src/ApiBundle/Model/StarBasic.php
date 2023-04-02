<?php

namespace ApiBundle\Model;

use SkyBundle\Entity\Star;

class StarBasic
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $radius;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @var float
     */
    private $volume;

    public function __construct(string $name, float $radius, float $temperature, float $volume)
    {
        $this->name = $name;
        $this->radius = $radius;
        $this->temperature = $temperature;
        $this->volume = $volume;
    }

    public static function creteFrom (Star $star): self
    {
        return new self(
            $star->getName(),
            $star->getRadius(),
            $star->getTemperature(),
            ((4/3) * pi() * pow($star->getRadius(), 3))
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius(float $radius): void
    {
        $this->radius = $radius;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): void
    {
        $this->volume = $volume;
    }
}