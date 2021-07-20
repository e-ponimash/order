<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderServiceInterface;

class OrderController extends Controller
{
    /**
     * @param OrderServiceInterface $order
     * @param OrderRequest $request
     */
    public function save(OrderServiceInterface $order, OrderRequest $request){
        $order->make($request->all());
    }
}
