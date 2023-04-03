<?php

namespace SkyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use SkyBundle\Entity\Star;
use SkyBundle\Model\Request\UniqueStarsRequestInterface;

/**
 * StarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StarRepository extends EntityRepository
{
    public function getUniqueStars(UniqueStarsRequestInterface $request)
    {
        $qb = $this->createQueryBuilder('ts');
        $qb
            ->leftJoin(
                Star::class,
                'ts2',
                Join::WITH,
                $qb->expr()->andX(
                    'ts2.galaxy = :galaxy_not_found_in',
                    'JSON_OVERLAPS(ts.atoms, ts2.atoms) = 1'
                )
            )
            ->where($qb->expr()->andX(
                $qb->expr()->isNull('ts2.id'),
                'ts.galaxy = :galaxy_found_in',
                'JSON_CONTAINS(ts.atoms, :atoms) = 1'
            ))
            ->addGroupBy('ts.id')
            ->setParameter('galaxy_not_found_in', $request->getNotFoundIn())
            ->setParameter('galaxy_found_in', $request->getFoundIn())
            ->setParameter('atoms', json_encode($request->getAtoms()))
        ;

        switch ($request->getSortBy()) {
            case 'size':
                $qb->addOrderBy('ts.radius');
                break;
            case 'temperature':
                $qb->addOrderBy('ts.temperature');
                break;
        }

        return $qb->getQuery()->getResult();
    }
}
