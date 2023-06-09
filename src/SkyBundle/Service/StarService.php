<?php

namespace SkyBundle\Service;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;
use SkyBundle\Entity\Star;
use SkyBundle\Model\Request\CreateStarRequestInterface;
use SkyBundle\Model\Request\UniqueStarsRequestInterface;
use SkyBundle\Model\Request\UpdateStarRequestInterface;
use SkyBundle\Repository\StarRepository;

class StarService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var StarRepository
     */
    private $starRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->starRepository = $em->getRepository(Star::class);
    }

    public function createStar(CreateStarRequestInterface $request): Star
    {
        $star = new Star();
        $star->setName($request->getName());
        $star->setGalaxy($request->getGalaxy());
        $star->setRadius($request->getRadius());
        $star->setTemperature($request->getTemperature());
        $star->setRotationFrequency($request->getRotationFrequency());
        $star->setAtoms($request->getAtoms());

        try {
            $this->em->persist($star);
            $this->em->flush();

            return $star;
        } catch (UniqueConstraintViolationException $e) {
            throw new InvalidArgumentException(
                "Unable to create the star. The given star name \"{$request->getName()}\" already exists in \"{$request->getGalaxy()}\"",
                0,
                $e
            );
        }
    }

    public function updateStar(Star $star, UpdateStarRequestInterface $request): Star
    {
        if ($name = $request->getName()) {
            $star->setName($name);
        }

        if ($galaxy = $request->getGalaxy()) {
            $star->setGalaxy($galaxy);
        }

        if ($radius = $request->getRadius()) {
            $star->setRadius($radius);
        }

        if ($temperature = $request->getTemperature()) {
            $star->setTemperature($temperature);
        }

        if ($rotationFrequency = $request->getRotationFrequency()) {
            $star->setRotationFrequency($rotationFrequency);
        }

        if (null !== $request->getAtoms()) {
            $star->setAtoms($request->getAtoms());
        }

        try {
            $this->em->persist($star);
            $this->em->flush();

            return $star;
        } catch (UniqueConstraintViolationException $e) {
            throw new InvalidArgumentException(
                "Unable to create the star. The given star name \"{$request->getName()}\" already exists in \"{$request->getGalaxy()}\"",
                0,
                $e
            );
        }
    }

    public function deleteStar(Star $star): void
    {
        $this->em->remove($star);
        $this->em->flush();
    }

    public function getUniqueStars(UniqueStarsRequestInterface $request): array
    {
        return $this->starRepository->getUniqueStars($request);
    }
}