<?php

namespace App\Entity\Main\Order;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\Main\Order\TrackingRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/order/tracking/{id}'),
        new GetCollection(uriTemplate: '/order/tracking'),
        new Post(uriTemplate: '/order/tracking'),
        new Put(uriTemplate: '/order/tracking/{id}'),
    ]
)]
#[ORM\Entity(repositoryClass: TrackingRepository::class)]
#[ORM\Table(name: 'order_tracking')]
class Tracking
{
    public const DELIVERED_STATUS = 'delivered';
    public const HANDOVERED_STATUS = 'handovered';
    public const PICKED_STATUS = 'picked';
    public const PAID_STATUS = 'paid';
    public const PENDING_STATUS = 'pending';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'order_number', type: 'string', length: 32, unique: true)]
    private ?string $orderNumber;

    #[ORM\Column(name: 'order_date', type: 'datetime', nullable: true)]
    private ?DateTime $orderDate;

    #[ORM\Column(name: 'carrier', type: 'string', length: 255, nullable: true)]
    private ?string $carrier;

    #[ORM\Column(name: 'order_picked_expected', type: 'string', length: 255, nullable: true)]
    private ?string $orderPickedExpected;

    #[ORM\Column(name: 'order_picked_real', type: 'datetime', nullable: true)]
    private ?DateTime $orderPickedReal;

    #[ORM\Column(name: 'order_handover_carrier_expected', type: 'string', length: 255, nullable: true)]
    private ?string $orderHandoverCarrierExpected;

    #[ORM\Column(name: 'order_handover_real', type: 'datetime', nullable: true)]
    private ?DateTime $orderHandoverReal;

    #[ORM\Column(name: 'order_delivered_expected', type: 'string', length: 255, nullable: true)]
    private ?string $orderDeliveredExpected;

    #[ORM\Column(name: 'delivered', type: 'datetime', nullable: true)]
    private ?DateTime $delivered;

    #[ORM\Column(name: 'postal_code', type: 'string', length: 255, nullable: true)]
    private ?string $postalCode;

    #[ORM\Column(name: 'country_code', type: 'string', length: 255, nullable: true)]
    private ?string $countryCode;

    #[ORM\Column(name: 'country', type: 'string', length: 255, nullable: true)]
    private ?string $country;

    #[ORM\Column(name: 'tracking_number', type: 'string', length: 255, nullable: true)]
    private ?string $trackingNumber;

    #[ORM\Column(name: 'payment_date', type: 'datetime', nullable: true)]
    private ?DateTime $paymentDate;

    #[ORM\Column(name: 'status', type: 'string', length: 255, nullable: true)]
    private ?string $status;

    #[ORM\Column(name: 'events', type: 'string', length: 255, nullable: true)]
    private ?string $events;

    #[ORM\Column(name: 'tracking_link', type: 'string', length: 255, nullable: true)]
    private ?string $trackingLink;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    protected ?DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getOrderDate(): ?DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(?DateTime $orderDate): self
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    public function setCarrier(?string $carrier): void
    {
        $this->carrier = $carrier;
    }

    public function getOrderPickedExpected(): ?string
    {
        return $this->orderPickedExpected;
    }

    public function setOrderPickedExpected(?string $orderPickedExpected): void
    {
        $this->orderPickedExpected = $orderPickedExpected;
    }

    public function getOrderPickedReal(): ?DateTime
    {
        return $this->orderPickedReal;
    }

    public function setOrderPickedReal(?DateTime $orderPickedReal): void
    {
        $this->orderPickedReal = $orderPickedReal;
    }

    public function getOrderHandoverCarrierExpected(): ?string
    {
        return $this->orderHandoverCarrierExpected;
    }

    public function setOrderHandoverCarrierExpected(?string $orderHandoverCarrierExpected): void
    {
        $this->orderHandoverCarrierExpected = $orderHandoverCarrierExpected;
    }

    public function getOrderHandoverReal(): ?DateTime
    {
        return $this->orderHandoverReal;
    }

    public function setOrderHandoverReal(?DateTime $orderHandoverReal): void
    {
        $this->orderHandoverReal = $orderHandoverReal;
    }

    public function getOrderDeliveredExpected(): ?string
    {
        return $this->orderDeliveredExpected;
    }

    public function setOrderDeliveredExpected(?string $orderDeliveredExpected): void
    {
        $this->orderDeliveredExpected = $orderDeliveredExpected;
    }

    public function getDelivered(): ?DateTime
    {
        return $this->delivered;
    }

    public function setDelivered(?DateTime $delivered): void
    {
        $this->delivered = $delivered;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(?string $trackingNumber): void
    {
        $this->trackingNumber = $trackingNumber;
    }

    public function getPaymentDate(): ?DateTime
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?DateTime $paymentDate): void
    {
        $this->paymentDate = $paymentDate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getEvents(): ?string
    {
        return $this->events;
    }

    public function setEvents(?string $events): void
    {
        $this->events = $events;
    }

    public function getTrackingLink(): ?string
    {
        return $this->trackingLink;
    }

    public function setTrackingLink(?string $trackingLink): void
    {
        $this->trackingLink = $trackingLink;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
