<?php
namespace App\Services;

use App\Models\Order;

interface OrderServiceInterface
{
    /**
     * @param array $params
     * @return Order
     */
    public function make(array $params): Order;
}
