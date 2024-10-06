<?php

namespace App\Repository\Magento;

use App\Entity\Magento\Orders;
use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{
    public function findByOrderId(string $orderId): ?Orders
    {
        return $this->findOneBy(['id' => $orderId]);
    }
}
