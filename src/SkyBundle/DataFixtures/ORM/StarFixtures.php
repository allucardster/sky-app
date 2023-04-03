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
        foreach (self::GALAXIES as $galaxy) {
            $starPrefix = $this->getGalaxyPrefix($galaxy);
            for ($i = 1; $i <= 10; $i++) {
               $star = new Star();
               $star->setName("{$starPrefix}-{$i}");
               $star->setGalaxy($galaxy);
               $star->setRadius(floatval(rand(696, 5000)));
               $star->setTemperature(floatval(rand(5772, 10000)));
               $star->setRotationFrequency(floatval(rand(24, 100)));

               $atoms = $this->getRandomElements();
               $star->setAtoms($atoms);
               $manager->persist($star);
            }
            $manager->flush();
            $manager->clear();
        }

        $galaxyAElements = $this->getRandomElements();
        $galaxyBElements = array_values(array_diff(Element::LIST, $galaxyAElements));

        $customGalaxies = [
            'Galaxy A' => $galaxyAElements,
            'Galaxy B' => $galaxyBElements,
        ];

        foreach($customGalaxies as $galaxy => $atoms) {
            $starPrefix = $this->getGalaxyPrefix($galaxy);
            for ($i = 1; $i <= 3; $i++) {
                $star = new Star();
                $star->setName("Star {$starPrefix}-{$i}");
                $star->setGalaxy($galaxy);
                $star->setRadius(floatval(rand(696, 5000)));
                $star->setTemperature(floatval(rand(5772, 10000)));
                $star->setRotationFrequency(floatval(rand(24, 100)));
                $star->setAtoms($this->getRandomElements($atoms));
                $manager->persist($star);
                $manager->flush();
            }
        }

        $star = new Star();
        $star->setName("Star GA-B-". uniqid());
        $star->setGalaxy('Galaxy A');
        $star->setRadius(floatval(rand(696, 5000)));
        $star->setTemperature(floatval(rand(5772, 10000)));
        $star->setRotationFrequency(floatval(rand(24, 100)));
        $star->setAtoms($galaxyBElements);
        $manager->persist($star);
        $manager->flush();
    }

    private function getRandomElements(array $elements = []): array
    {
        $elements = empty($elements) ? Element::LIST : $elements;
        $total = count($elements);
        $min = $total > 1 ? 2 : 1;
        $max = $total > 10 ? 10 : $total;
        $num = rand($min, $max);

        $elementKeys = array_rand($elements, $num);
        if (!is_array($elementKeys)) {
            $elementKeys = [$elementKeys];
        }

        return array_map(function ($key) use ($elements) {
            return $elements[$key];
        }, $elementKeys);
    }

    private function getGalaxyPrefix(string $galaxy)
    {
        return array_reduce(
            explode(' ', $galaxy),
            function ($carry, $item) {
                return $carry . substr($item, 0, 1);
            },
            ''
        );
    }
}