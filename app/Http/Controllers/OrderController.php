<?php

namespace App\Http\Controllers;

use Imagick;
use ImagickDraw;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{
    public function addTextToImage($image, $text, $fontSize, $yPosition)
    {
        $draw = new ImagickDraw();
        $draw->setFont('./fonts/Mono.ttf');
        $draw->setFontSize($fontSize);
        $imageWidth = $image->getImageWidth();
        $metrics = $image->queryFontMetrics($draw, $text);
        $textWidth = $metrics['textWidth'];
        $x = ($imageWidth - $textWidth) / 2;
        $draw->annotation($x, $yPosition, $text);
        $image->drawImage($draw);
        return $image;
    }
    public function generateTicket()
    {

        $image = new Imagick('./ticket_template.png');
        $draw = new ImagickDraw();

        $this->addTextToImage($image, "Hello World", 28, 320);
        $this->addTextToImage($image, "100,200,300,400,500", 30, 520);
        $this->addTextToImage($image, "Lucky Draw Date - 20-03-2023", 40, 680);
        $this->addTextToImage($image, "Total Lucky Numbers - 5", 30, 840);
        $this->addTextToImage($image, "TK909932093", 40, 1000);

        // Save or display the image
        $image->writeImage(public_path() . '/abc.png');
        // Set the image format (e.g., "jpeg", "png")
        $image->setImageFormat('png');

        // Create the response object
        $response = new Response();

        // Set headers
        $response->header('Content-Type', 'image/png');

        // Set the content
        $response->setContent($image->getImageBlob());

        return $response;
        // $img = Image::make('foo.jpg')->resize(300, 200);
        // return view('welcome');
    }

    public function placeOrder(Request $request)
    {
        return view('place_order');
    }
}
