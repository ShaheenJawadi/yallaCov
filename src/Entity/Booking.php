<?php
namespace App\Entity;

use App\Enum\BookingStatus;
use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column]
    private ?int $seatsBooked = null;

    #[ORM\Column(length: 20, enumType: BookingStatus::class)]
    private BookingStatus $status = BookingStatus::PENDING;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalPrice = null;



    #[ORM\ManyToOne(targetEntity: Ride::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ride $ride = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $passenger = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSeatsBooked(): ?int
    {
        return $this->seatsBooked;
    }

    public function setSeatsBooked(?int $seatsBooked): void
    {
        $this->seatsBooked = $seatsBooked;
    }

    public function getStatus(): BookingStatus
    {
        return $this->status;
    }

    public function setStatus(BookingStatus $status): void
    {
        $this->status = $status;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?string $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getRide(): ?Ride
    {
        return $this->ride;
    }

    public function setRide(?Ride $ride): void
    {
        $this->ride = $ride;
    }

    public function getPassenger(): ?User
    {
        return $this->passenger;
    }

    public function setPassenger(?User $passenger): void
    {
        $this->passenger = $passenger;
    }



}