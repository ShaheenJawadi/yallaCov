<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\RideType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Enum\BookingStatus;
use App\Entity\Booking;
use App\Repository\RideRepository;
 


class RideController extends AbstractController
{

    private $entityManager;
    private $userRepository;
 
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }


    #[Route('/driver/new', name: 'app_new_ride')]
    public function new(Request $request): Response
    {
        $ride = new Ride();
 
        $driver = $this->getUser();
 
        if ($driver) {
            $ride->setDriver($driver);  
        }
 
        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $this->entityManager->persist($ride);
            $this->entityManager->flush();
 
            return $this->redirectToRoute('app_ride_listing');
        }

        return $this->render('ride/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }












    #[Route('/ride/{id}/book', name: 'ride_book', methods: ['POST'])]
    public function bookRide(
        int $id, 
        Request $request, 
        RideRepository $rideRepository, 
        EntityManagerInterface $entityManager
    ): Response {
        $ride = $rideRepository->find($id);

        if (!$ride) {
            throw $this->createNotFoundException('Ride not found');
        }

        $seatsBooked = $request->request->get('seatsBooked');
        if ($seatsBooked > $ride->getAvailableSeats()) {
            $this->addFlash('error', "Il n'y a pas assez de places disponibles pour ce trajet.");
            return $this->redirectToRoute('app_ride_listing' );
        }

        $booking = new Booking();
        $booking->setRide($ride);
        $booking->setPassenger($this->getUser());
        $booking->setSeatsBooked($seatsBooked);
        $booking->setTotalPrice($seatsBooked * $ride->getPricePerSeat());
        $booking->setStatus(BookingStatus::PENDING);
 
        $ride->setAvailableSeats($ride->getAvailableSeats() - $seatsBooked);

        $entityManager->persist($booking);
        $entityManager->persist($ride);
        $entityManager->flush();

        $this->addFlash('success', 'Réservation confirmée avec succès !');
        return $this->redirectToRoute('app_ride_listing' );
    }
}
