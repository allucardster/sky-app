<?php

namespace SkyBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SkyBundle\Entity\Star;
use SkyBundle\Model\Element;

class StarFixtures extends Fixture
{
    private const GALAXIES = [
        'Andromeda Galaxy',
        'Canis Major Dwarf Galaxy',
        'Cygnus A',
        'Maffei I and II',
        'Magellanic Clouds',
        'Milky Way Galaxy',
        'Virgo A',
    ];

    public function load(ObjectManager $manager)
    {
        $elements = Element::LIST;
        $selectedElements = [];
        foreach (self::GALAXIES as $galaxy) {
            $starPrefix = array_reduce(
                explode(' ', $galaxy),
                function ($carry, $item) {
                    return $carry . substr($item, 0, 1);
                },
                ''
            );
            for ($i = 1; $i <= 10; $i++) {
               $star = new Star();
               $star->setName("{$starPrefix}-{$i}");
               $star->setGalaxy($galaxy);
               $star->setRadius(floatval(rand(696, 5000)));
               $star->setTemperature(floatval(rand(5772, 10000)));
               $star->setRotationFrequency(floatval(rand(24, 100)));

               $atoms = array_map(function ($key) use ($elements) {
                   return $elements[$key];
               }, array_rand($elements, rand(2, 10)));
               $star->setAtoms($atoms);
               $selectedElements = array_unique(array_merge($selectedElements, $atoms));
               $manager->persist($star);
            }
            $manager->flush();
            $manager->clear();
        }

        $uniqueAtoms = array_values(array_diff($elements, $selectedElements)) ?: ['gold'];

        $star = new Star();
        $star->setName("Trisol-1");
        $star->setGalaxy('Galaxy of Terror');
        $star->setRadius(floatval(rand(696, 5000)));
        $star->setTemperature(floatval(rand(5772, 10000)));
        $star->setRotationFrequency(floatval(rand(24, 100)));
        $star->setAtoms($uniqueAtoms);
        $manager->persist($star);
        $manager->flush();
        $manager->clear();
    }
}