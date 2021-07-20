<?php
namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Jobs\GenerateBarcodeTask;
use App\Models\Order;

class OrderService implements OrderServiceInterface
{
    /**
     * @param array $params
     * @return Order
     */
    public function make(array $params): Order
    {
        $order = Order::create($params);

        dispatch(new GenerateBarcodeTask($order));
        return $order;
    }
}
