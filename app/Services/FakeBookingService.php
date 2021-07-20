<?php


namespace App\Services;


class FakeBookingService implements BookingServiceInterface
{
    /**
     * @param $event_id
     * @param $event_date
     * @param $ticket_adult_price
     * @param $ticket_adult_quantity
     * @param $ticket_kid_price
     * @param $ticket_kid_quantity
     * @param $barcode
     * @return mixed|string[]
     */
    public function book($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode)
    {
        $responses = array(
            ["message" => "order successfully booked"],
            ["error" => 'barcode already exists']
        );
        return $responses[rand(0, count($responses)-1)];
    }

    /**
     * @param $barcode
     * @return mixed|string[]
     */
    public function approve($barcode)
    {
        $responses = array(
            ["message" => "order successfully approved"],
            ["error" => 'event cancelled'],
            ["error" => 'no tickets'],
            ["error" => 'no seats'],
            ["error" => 'fan removed'],
        );
        return $responses[rand(0, count($responses)-1)];
    }
}
