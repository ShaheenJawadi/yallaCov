<?php
namespace App\Entity;

use App\Enum\RideStatus;
use App\Repository\RideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RideRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ride
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rides')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $driver = null;

    #[ORM\Column(length: 255)]
    private ?string $departureCity = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalCity = null;

    
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $departureTime = null;   

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $departureDate = null;   


    #[ORM\Column]
    private ?int $availableSeats = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $pricePerSeat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $vehicleDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\Column(length: 20, enumType: RideStatus::class)]
    private RideStatus $status = RideStatus::PENDING;

    #[ORM\Column]
    private ?bool $isActive = true;

    #[ORM\OneToMany(mappedBy: 'ride', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'ride', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'ride', targetEntity: Message::class)]
    private Collection $messages;



    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(?User $driver): void
    {
        $this->driver = $driver;
    }

    public function getDepartureCity(): ?string
    {
        return $this->departureCity;
    }

    public function setDepartureCity(?string $departureCity): void
    {
        $this->departureCity = $departureCity;
    }

    public function getArrivalCity(): ?string
    {
        return $this->arrivalCity;
    }

    public function setArrivalCity(?string $arrivalCity): void
    {
        $this->arrivalCity = $arrivalCity;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(?\DateTimeInterface $departureTime): void
    {
        $this->departureTime = $departureTime;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): void
    {
        $this->departureDate = $departureDate;
    }

    public function getAvailableSeats(): ?int
    {
        return $this->availableSeats;
    }

    public function setAvailableSeats(?int $availableSeats): void
    {
        $this->availableSeats = $availableSeats;
    }

    public function getPricePerSeat(): ?string
    {
        return $this->pricePerSeat;
    }

    public function setPricePerSeat(?string $pricePerSeat): void
    {
        $this->pricePerSeat = $pricePerSeat;
    }

    public function getVehicleDescription(): ?string
    {
        return $this->vehicleDescription;
    }

    public function setVehicleDescription(?string $vehicleDescription): void
    {
        $this->vehicleDescription = $vehicleDescription;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(?string $additionalNotes): void
    {
        $this->additionalNotes = $additionalNotes;
    }

    public function getStatus(): RideStatus
    {
        return $this->status;
    }

    public function setStatus(RideStatus $status): void
    {
        $this->status = $status;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function setBookings(Collection $bookings): void
    {
        $this->bookings = $bookings;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function setMessages(Collection $messages): void
    {
        $this->messages = $messages;
    }





}