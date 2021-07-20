<?php

namespace App\Services;


interface BookingServiceInterface {
    /**
     * @param $event_id
     * @param $event_date
     * @param $ticket_adult_price
     * @param $ticket_adult_quantity
     * @param $ticket_kid_price
     * @param $ticket_kid_quantity
     * @param $barcode
     * @return mixed
     */
    public function book($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode);

    /**
     * @param $barcode
     * @return mixed
     */
    public function approve($barcode);
}
