<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\BarcodeService;
use App\Services\BookingServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class GenerateBarcodeTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param BarcodeService $barcodeService
     * @param BookingServiceInterface $bookingService
     * @return void
     */
    public function handle(BarcodeService $barcodeService, BookingServiceInterface $bookingService)
    {
        try {
            $this->order->barcode = $barcodeService->generate();
            $this->order->save();

            $result = $bookingService->book(
                $this->order->event_id,
                $this->order->event_date,
                $this->order->ticket_adult_price,
                $this->order->ticket_adult_quantity,
                $this->order->ticket_kid_price,
                $this->order->ticket_kid_quantity,
                $this->order->barcode
            );
            if(array_key_exists('error', $result))
                throw new \Exception($result['error']);

            $result = $bookingService->approve($this->order->barcode);
            if(array_key_exists('error', $result))
                throw new \Exception($result['error']);

        } catch (\Exception $exception){
            dispatch(new GenerateBarcodeTask($this->order));
        }
    }
}
