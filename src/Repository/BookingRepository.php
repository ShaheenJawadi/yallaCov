<?php

namespace App\Repository;
use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findBookingsByDriver(User $driver)
{
    return $this->createQueryBuilder('b')
        ->join('b.ride', 'r')
        ->andWhere('r.driver = :driver')
        ->setParameter('driver', $driver)
        ->orderBy('b.status', 'ASC')
        ->getQuery()
        ->getResult();
}


}