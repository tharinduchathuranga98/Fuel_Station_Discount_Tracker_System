<?php
namespace App\Helpers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeHelper
{
    public static function generateQrCode($data)
    {
        // Create QR code with data
        $qrCode = new QrCode($data); // Create the QR code object

        // Create writer
        $writer = new PngWriter();

        // Write the QR code to a PNG image
        $result = $writer->write($qrCode);

        // Return base64 encoded PNG image
        return base64_encode($result->getString());
    }
}
