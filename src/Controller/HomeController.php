<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use App\Repository\RideRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/list', name: 'app_ride_listing')]
    public function list(Request $request, RideRepository $rideRepository): Response
    {
        $departureCity = $request->query->get('departureCity');
        $arrivalCity = $request->query->get('arrivalCity');
        $departureDate = $request->query->get('departureDate');
        $departureTime = $request->query->get('departureTime');

        
        $rides = $rideRepository->findByCriteria($departureCity, $arrivalCity, $departureDate, $departureTime);

        return $this->render('home/list.html.twig', [
            'rides' => $rides,
        ]);
 
    }

}