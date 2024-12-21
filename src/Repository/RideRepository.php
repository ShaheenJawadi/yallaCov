<?php

namespace App\Repository;

use App\Entity\Ride;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ride::class);
    }


    public function findByCriteria(?string $departureCity, ?string $arrivalCity, ?string $departureDate, ?string $departureTime)
    {
        $qb = $this->createQueryBuilder('r');

        if ($departureCity) {
            $qb->andWhere('r.departureCity LIKE :departureCity')
               ->setParameter('departureCity', '%' . $departureCity . '%');
        }

        if ($arrivalCity) {
            $qb->andWhere('r.arrivalCity LIKE :arrivalCity')
               ->setParameter('arrivalCity', '%' . $arrivalCity . '%');
        }

        if ($departureDate) {
            $date = new \DateTime($departureDate);  
            $qb->andWhere('r.departureDate >=:departureDate')
               ->setParameter('departureDate', $date->format('Y-m-d'));  
        }

         
        if ($departureTime) {
            $time = \DateTime::createFromFormat('H:i', $departureTime);  
            $qb->andWhere('r.departureTime >= :departureTime')
               ->setParameter('departureTime', $time->format('H:i:s'));  
        }


        return $qb->getQuery()->getResult();
    }

}