<?php

namespace App\Entity\Magento;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "sunday_customersegment_website")]
#[ORM\Index(columns: ["website_id"], name: "SUNDAY_CUSTOMERSEGMENT_WEBSITE_WEBSITE_ID")]
class CustomerSegmentWebsite
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: CustomerSegment::class)]
    #[ORM\JoinColumn(name: "segment_id", referencedColumnName: "segment_id", nullable: false, onDelete: "CASCADE")]
    private CustomerSegment $segment;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: StoreWebsite::class)]
    #[ORM\JoinColumn(name: "website_id", referencedColumnName: "website_id", nullable: false, onDelete: "CASCADE")]
    private StoreWebsite $website;

    public function getSegment(): CustomerSegment
    {
        return $this->segment;
    }

    public function setSegment(CustomerSegment $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function getWebsite(): StoreWebsite
    {
        return $this->website;
    }

    public function setWebsite(StoreWebsite $website): self
    {
        $this->website = $website;
        return $this;
    }
}
