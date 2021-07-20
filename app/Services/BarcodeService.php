<?php
namespace App\Services;


class BarcodeService
{
    /**
     * @param int $length
     * @return string
     */
    public function generate($length = 10): string{
        $barcode = '';
        for ($i = 0; $i < $length; $i++) {
            $barcode .= rand(0, 9);
        }
        return $barcode;
    }
}
