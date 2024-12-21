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
}
