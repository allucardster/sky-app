<?php

namespace SkyBundle\Model\Request;

interface UpdateStarRequestInterface
{
    public function getName(): ?string;

    public function getGalaxy(): ?string;

    public function getRadius(): ?float;

    public function getTemperature(): ?float;

    public function getRotationFrequency(): ?float;

    public function getAtoms(): ?array;
}